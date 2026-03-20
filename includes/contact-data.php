<?php
/**
 * Datos de contacto compartidos
 * Usado en: template-parts/contact.php y footer.php
 */

if ( ! defined('ABSPATH') ) exit;

global $contact_address, $contact_phone, $contact_email, $contact_hours, $contact_map_url, $social_links, $social_icons;

$home_id = get_option('page_on_front');

$contact_intro    = get_field('contact_intro',    $home_id) ?: 'Estamos aquí para escucharte. Puedes visitarnos en nuestras oficinas, llamarnos o enviarnos un mensaje a través del formulario.';
$contact_address  = get_field('contact_address',  $home_id) ?: 'Av. Virgen del Pilar s/n, Área de Sociales de la UNSA. Referencia: al costado del Comedor Universitario';
$contact_phone    = get_field('contact_phone',     $home_id) ?: '+51 932 907 594';
$contact_email    = get_field('contact_email',     $home_id) ?: 'defensoria@unsa.edu.pe';
$contact_hours    = get_field('contact_hours',     $home_id) ?: 'Lunes a Viernes: 8:30 AM - 3:40 PM';
$contact_map_url  = get_field('contact_map_url',   $home_id) ?: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d956.8418514942298!2d-71.52196753434885!3d-16.40615648432324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91424b4ab43c09f1%3A0x76543ca3cba745d!2sDefensoria%20Universitaria%20-%20UNSA!5e0!3m2!1ses!2spe!4v1771854708866!5m2!1ses!2spe';

// Redes sociales
$contact_facebook  = get_field('contact_facebook',  $home_id) ?: 'https://www.facebook.com/DefUnsa/';
$contact_instagram = get_field('contact_instagram', $home_id) ?: '';
$contact_tiktok    = get_field('contact_tiktok',    $home_id) ?: '';
$contact_twitter   = get_field('contact_twitter',   $home_id) ?: '';

// Array de redes activas (solo las que tienen URL)
$social_links = array_filter([
    'facebook'  => $contact_facebook,
    'instagram' => $contact_instagram,
    'tiktok'    => $contact_tiktok,
    'twitter'   => $contact_twitter,
]);

// Iconos SVG minimalistas relleno #141F40
$social_icons = [
    'facebook' => [
        'label' => 'Facebook',
        'svg'   => '<path fill="#141F40" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>',
    ],
    'instagram' => [
        'label' => 'Instagram',
        'svg'   => '<path fill="#141F40" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>',
    ],
    'tiktok' => [
        'label' => 'TikTok',
        'svg'   => '<path fill="#141F40" d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.27 6.27 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.76a4.85 4.85 0 01-1.01-.07z"/>',
    ],
    'twitter' => [
        'label' => 'X / Twitter',
        'svg'   => '<path fill="#141F40" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>',
    ],
];