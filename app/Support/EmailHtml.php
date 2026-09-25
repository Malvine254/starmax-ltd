<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class EmailHtml
{
    private const ALLOWED_ELEMENTS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's',
        'h2', 'h3', 'ul', 'ol', 'li', 'blockquote', 'a',
    ];

    public static function sanitize(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        if ($html === strip_tags($html)) {
            return collect(preg_split('/\R{2,}/', $html))
                ->map(fn (string $paragraph) => '<p>'.nl2br(e(trim($paragraph)), false).'</p>')
                ->implode('');
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $previousErrors = libxml_use_internal_errors(true);
        $document->loadHTML(
            '<?xml encoding="UTF-8"><div id="email-content">'.$html.'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD,
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previousErrors);

        $root = $document->getElementById('email-content');
        if (! $root) {
            return '';
        }

        self::sanitizeChildren($root);

        $clean = '';
        foreach ($root->childNodes as $child) {
            $clean .= $document->saveHTML($child);
        }

        return trim($clean);
    }

    private static function sanitizeChildren(DOMNode $parent): void
    {
        foreach (iterator_to_array($parent->childNodes) as $node) {
            if (! $node instanceof DOMElement) {
                continue;
            }

            $tag = strtolower($node->tagName);
            if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed'], true)) {
                $parent->removeChild($node);
                continue;
            }

            if (! in_array($tag, self::ALLOWED_ELEMENTS, true)) {
                self::unwrap($node);
                continue;
            }

            foreach (iterator_to_array($node->attributes) as $attribute) {
                if ($tag !== 'a' || strtolower($attribute->name) !== 'href') {
                    $node->removeAttribute($attribute->name);
                }
            }

            if ($tag === 'a') {
                $href = trim($node->getAttribute('href'));
                if (! preg_match('/^(https?:|mailto:|#)/i', $href)) {
                    $node->removeAttribute('href');
                }
            }

            $styles = [
                'p' => 'margin:0 0 14px;',
                'h2' => 'margin:20px 0 10px;font-size:20px;line-height:1.3;',
                'h3' => 'margin:18px 0 8px;font-size:16px;line-height:1.4;',
                'ul' => 'margin:0 0 16px;padding-left:24px;',
                'ol' => 'margin:0 0 16px;padding-left:24px;',
                'li' => 'margin:0 0 7px;',
                'blockquote' => 'margin:16px 0;padding:10px 14px;border-left:3px solid #d97706;color:#475569;background:#f8fafc;',
                'a' => 'color:#9a6819;text-decoration:underline;',
            ];
            if (isset($styles[$tag])) {
                $node->setAttribute('style', $styles[$tag]);
            }

            self::sanitizeChildren($node);
        }
    }

    private static function unwrap(DOMElement $element): void
    {
        $parent = $element->parentNode;
        if (! $parent) {
            return;
        }

        while ($element->firstChild) {
            $parent->insertBefore($element->firstChild, $element);
        }
        $parent->removeChild($element);
        self::sanitizeChildren($parent);
    }
}