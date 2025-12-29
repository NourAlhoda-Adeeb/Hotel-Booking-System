<?php

namespace App\Libraries;

class Arabic
{
    public function utf8Glyphs($text)
    {
        // تحويل النص العربي ليدعم Dompdf
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        // عكس الاتجاه
        $text = preg_replace_callback('/>([^<]+)</u', function ($matches) {
            return '>' . $this->rtl($matches[1]) . '<';
        }, $text);

        return $text;
    }

    private function rtl($text)
    {
        // عكس النص العربي فقط
        if (preg_match('/[\x{0600}-\x{06FF}]/u', $text)) {
            return implode('', array_reverse(preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY)));
        }
        return $text;
    }
}
