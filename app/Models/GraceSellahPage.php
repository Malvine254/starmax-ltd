<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraceSellahPage extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'slug',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

    public static function defaultContent(): array
    {
        return [
            'meta' => [
                'title' => 'Grace Sellah Atemo - Virtual Assistant',
                'description' => 'Professional virtual assistant services for entrepreneurs, small businesses and busy professionals.',
            ],
            'brand' => [
                'label' => 'Grace',
                'footer_label' => 'Grace',
            ],
            'labels' => [
                'nav_home' => 'Home',
                'nav_about' => 'About',
                'nav_services' => 'Services',
                'nav_portfolio' => 'Work',
                'nav_tools' => 'Tools',
                'nav_contact' => 'Contact',
                'nav_cta' => 'Work with me',
                'services_eyebrow' => 'What I offer',
                'services_title' => 'Support designed around your day',
                'services_subtitle' => 'Practical, dependable support that gives you more time for the work that matters.',
                'portfolio_eyebrow' => 'Selected work',
                'portfolio_title' => 'A closer look at what I deliver',
                'portfolio_subtitle' => 'Clear systems, polished documents, and organized operations.',
                'tools_eyebrow' => 'My toolkit',
                'tools_title' => 'Tools I work with',
                'tools_subtitle' => 'A flexible, remote-ready stack for communication, organization, and reporting.',
                'form_title' => 'Tell me what you need',
                'form_name_label' => 'Your name',
                'form_email_label' => 'Email address',
                'form_service_label' => 'How can I help?',
                'form_message_label' => 'A little about your needs',
                'form_submit_label' => 'Send enquiry',
            ],
            'hero' => [
                'eyebrow' => 'Professional Virtual Assistant',
                'title_lines' => [
                    'Save Time,',
                    'Stay Organized,',
                    'Grow Your Business.',
                ],
                'highlight' => 'Grow Your Business.',
                'subtitle' => 'Supporting Entrepreneurs, Small Businesses & Busy Professionals',
                'background_image' => 'https://images.unsplash.com/photo-1497032628192-86f99bcd76bc?w=1600&q=80',
                'actions' => [
                    ['label' => 'Explore My Services', 'href' => '#services', 'variant' => 'btn-primary'],
                    ['label' => "Let's Work Together", 'href' => '#contact', 'variant' => 'btn-outline'],
                ],
            ],
            'strip_cards' => [
                ['title' => 'Admin Support', 'description' => 'Email, calendar, data entry & document management'],
                ['title' => 'HR & Office Support', 'description' => 'Recruitment, records, SOPs & HR documentation'],
                ['title' => 'Client Support', 'description' => 'Inquiries, follow-ups, scheduling & records'],
                ['title' => 'Bookkeeping & Invoicing', 'description' => 'Invoices, expense tracking & transaction records'],
            ],
            'about' => [
                'eyebrow' => 'Meet Grace',
                'title' => 'Grace Sellah Atemo',
                'description' => [
                    'I am a professional Virtual Assistant with a background in Administration and Human Resource Management. I support businesses by managing daily operations, improving organization, and ensuring smooth communication.',
                    'I am committed to delivering reliable, efficient, and detail-oriented support that allows businesses to focus on growth and productivity.',
                ],
                'profile_image_path' => '',
                'profile_image_url' => '',
                'profile_image_alt' => 'Grace Sellah Atemo portrait',
                'photo_note' => 'Add your photo here',
                'badge_number' => '3+',
                'badge_text' => 'Years Experience',
                'highlights' => [
                    'Admin & HR Background',
                    'Detail-Oriented & Reliable',
                    'Remote-Ready Professional',
                ],
                'cta_label' => 'Work With Me',
            ],
            'services' => [
                [
                    'title' => 'Administrative Support',
                    'gradient' => 'linear-gradient(135deg,#2d4a3e,#4a7c5f)',
                    'items' => [
                        'Email management (organizing & responding)',
                        'Calendar & meeting scheduling',
                        'Data entry and record keeping',
                        'File organization (Google Drive & Dropbox)',
                        'Document preparation (reports, letters, forms)',
                        'Travel coordination and planning',
                    ],
                ],
                [
                    'title' => 'HR & Office Support',
                    'gradient' => 'linear-gradient(135deg,#3a3060,#6c5ce7)',
                    'items' => [
                        'Employee records management',
                        'Recruitment coordination & interview scheduling',
                        'Preparation of HR documents (contracts, JDs)',
                        'Development of SOPs and HR manuals',
                        'Training support & materials preparation',
                    ],
                ],
                [
                    'title' => 'Customer & Client Support',
                    'gradient' => 'linear-gradient(135deg,#7a2828,#c0392b)',
                    'items' => [
                        'Responding to customer inquiries (email & chat)',
                        'Managing client communication & follow-ups',
                        'Handling customer requests',
                        'Scheduling appointments and meetings',
                        'Maintaining client records',
                        'Providing professional & timely support',
                    ],
                ],
                [
                    'title' => 'Bookkeeping & Invoicing',
                    'gradient' => 'linear-gradient(135deg,#1a4a6e,#2980b9)',
                    'items' => [
                        'Creating and sending invoices',
                        'Tracking expenses',
                        'Recording transactions',
                        'Using Zoho Books & QuickBooks',
                    ],
                ],
            ],
            'portfolio' => [
                ['title' => 'Calendar Management', 'description' => 'Organised multi-user calendars using Google Calendar with colour-coded events and automated reminders.', 'background' => '#e8f4e8', 'accent' => '#2d4a3e'],
                ['title' => 'Email Management', 'description' => 'Structured inbox with priority labels, filters and professional templates for faster response times.', 'background' => '#ede8f4', 'accent' => '#6c5ce7'],
                ['title' => 'Travel Planning', 'description' => 'Full itineraries including accommodation, flight schedules, and activity bookings for executive travel.', 'background' => '#fde8e8', 'accent' => '#c0392b'],
                ['title' => 'Expense Tracking', 'description' => 'Monthly expense reports with charts and budget summaries using Google Sheets and Zoho Books.', 'background' => '#e8f0fe', 'accent' => '#2980b9'],
                ['title' => 'Invoicing & Recording', 'description' => 'Professional invoices and transaction logs with reconciliation reports for small businesses.', 'background' => '#fff3e0', 'accent' => '#e67e22'],
                ['title' => 'SOPs Preparation', 'description' => 'Step-by-step standard operating procedures for operational workflows and staff onboarding.', 'background' => '#e8f8f5', 'accent' => '#27ae60'],
                ['title' => 'Job Description Preparation', 'description' => 'Structured JDs covering roles, responsibilities, qualifications and reporting lines.', 'background' => '#fdf2f8', 'accent' => '#8e44ad'],
                ['title' => 'HR Manual Development', 'description' => 'Comprehensive HR manuals aligned with legal and operational requirements.', 'background' => '#fef9e7', 'accent' => '#f39c12'],
                ['title' => 'Meeting Coordination & Agenda', 'description' => 'End-to-end meeting setup including agenda creation, minutes documentation and follow-ups.', 'background' => '#eaf4fb', 'accent' => '#2471a3'],
            ],
            'tools' => [
                ['name' => 'Gmail', 'color' => '#EA4335'],
                ['name' => 'Google Calendar', 'color' => '#4285F4'],
                ['name' => 'Google Drive', 'color' => '#FBBC04'],
                ['name' => 'Calendly', 'color' => '#006BFF'],
                ['name' => 'Canva', 'color' => '#00C4CC'],
                ['name' => 'PowerPoint', 'color' => '#D24726'],
                ['name' => 'Google Sheets', 'color' => '#0F9D58'],
                ['name' => 'Google Docs', 'color' => '#4285F4'],
                ['name' => 'Google Meet', 'color' => '#00897B'],
                ['name' => 'Zoom', 'color' => '#2D8CFF'],
                ['name' => 'Zoho Books', 'color' => '#E4252B'],
                ['name' => 'QuickBooks', 'color' => '#2CA01C'],
                ['name' => 'Dropbox', 'color' => '#0061FF'],
                ['name' => 'WhatsApp Business', 'color' => '#25D366'],
                ['name' => 'Slack', 'color' => '#4A154B'],
            ],
            'contact' => [
                'eyebrow' => 'Get In Touch',
                'title' => "Let's Work Together",
                'description' => 'I am available for Virtual Assistant opportunities and ready to support your business with efficient, reliable, and organized services. Let\'s work together to help your business grow.',
                'email' => 'atemograce942@gmail.com',
                'phone' => '0713 777 006',
                'phone_tel' => '0713777006',
                'linkedin_label' => 'linkedin.com/in/grace-atemo',
                'linkedin_url' => 'https://www.linkedin.com/in/grace-atemo',
                'service_options' => [
                    'Administrative Support',
                    'HR & Office Support',
                    'Customer & Client Support',
                    'Bookkeeping & Invoicing',
                    'Other',
                ],
            ],
            'footer' => [
                'copy' => '© 2026 Grace Sellah Atemo. All rights reserved.',
            ],
        ];
    }

    public function mergedContent(): array
    {
        return array_replace_recursive(self::defaultContent(), $this->content ?? []);
    }
}
