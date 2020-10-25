<?php
class gt_textsan
{
    public $input;

    public $output;

    public function __construct()
    {
        $this->input = '';

        $this->output = '';
    }

    public function filename($input)
    {
        $llimit = 0; // 1 or 0, limits filenames to 16 chars

        $input = mb_strtolower($input);

        $input = chunk_preg_split($input, 1, '&666;');

        $input = explode('&666;', $input);

        unset($input[count($input) - 1]);

        // replacements:

        $replacements[' '] = '_';

        $replacements['/'] = '/';

        foreach ($input as $key => $char) {
            if (!preg_match("[a-z0-9\-_]", $char)) {
                // if it isn't alphanumeric:

                if (isset($replacements[$char])) {
                    $input[$key] = $replacements[$char];
                } else {
                    $input[$key] = '-';
                }
            }
        }

        if (1 == $llimit) {
            // check length, shooting for 16 chars per folder/file

            $input = explode('/', implode('', $input));

            foreach ($input as $key => $value) {
                if (mb_strlen($value) > 16) {
                    $value = explode('&666;', chunk_preg_split($value, 16, '&666;'));

                    $input[$key] = $value[0];
                }
            }

            $input = implode('/', $input);
        } else {
            $input = implode('', $input);
        }

        return($input);
    }

    public function sanitize($input)
    {
        if ('' == $input) {
            $input = $this->output;
        } else {
            $this->input = $input;
        }

        $var = $this->input;

        //strip slashes

        $var = stripslashes($var);

        //strip HTML

        $var = preg_replace('<', '&lt;', $var);

        $var = preg_replace('>', '&gt;', $var);

        $var = preg_replace('"', '&quot;', $var);

        $var = preg_replace("'", '&#39;', $var);

        $this->output = $var;

        return($this->output);
    }

    public function fix_linebreaks($input)
    {
        $var = preg_replace("/\[(.+)\](([^\n\[\]]*)?\n([^\n\[\]]*)?)+?\[\/(.+)\]/", '[fixbreak]\\1&#666;\\0[fixbreak]', $input);

        $chunks = explode('[fixbreak]', $var);

        foreach ($chunks as $chunkid => $thischunk) {
            echo "<div>$chunkid: $thischunk</div>";

            $thischunk_exploded = explode('&#666;', $thischunk);

            if (2 == count($thischunk_exploded)) {
                echo "fixing chunk $chunkid";

                $chunks[$chunkid] = preg_replace("/\n/", '[/' . $thischunk_exploded[0] . "]\n[" . $thischunk_exploded[0] . ']', $thischunk_exploded[1]);
            }
        }

        return(implode('', $chunks));
    }

    public function html_to_ubb($input)
    {
        $var = $input;

        //B, U, I

        $var = preg_replace("/\<b\>(.+)\<\/b\>/", '[b]\\1[/b]', $var);

        $var = preg_replace("/\<u\>(.+)\<\/u\>/", '[u]\\1[/u]', $var);

        $var = preg_replace("/\<i\>(.+)\<\/i\>/", '[i]\\1[/i]', $var);

        //Email

        $var = preg_replace("/\<a href=\"mailto:([a-zA-Z0-9_-]+)@([a-zA-Z0-9_-]+)([\.a-zA-Z0-9_-]+)\"\>(.+)<\/a\>/", '\\4', $var);

        //URL

        $var = preg_replace("/\<a href=\"(.+)\" target=_blank\>(.+)\<\/a\>/", '[url=\\1]\\2[/url]', $var);

        $var = preg_replace("/\<a href=\"(.+)\"\>(.+)\<\/a\>/", '[url=\\1]\\2[/url]', $var);

        $var = preg_replace("/\<a href=\"(.+)\" target=_blank\>\\1\<\/a\>/", '[url]\\1[/url]', $var);

        //IMG

        $var = preg_replace("/\<img(.+)src=[\"\'](.+)[\"\'](.+)\>/", '[img]\\2[/img]', $var);

        //Quote \\2@\\3\\4

        $var = preg_replace("/\<blockquote\>(.+)\<\/blockquote\>/", '[quote]\\1[/quote]', $var);

        //B, U, I

        $var = preg_replace("/\<B\>(.+)\<\/B\>/", '[b]\\1[/b]', $var);

        $var = preg_replace("/\<U\>(.+)\<\/U\>/", '[u]\\1[/u]', $var);

        $var = preg_replace("/\<I\>(.+)\<\/I\>/", '[i]\\1[/i]', $var);

        //Email

        $var = preg_replace("/\<A HREF=\"mailto:([a-zA-Z0-9_-]+)@([a-zA-Z0-9_-]+)([\.a-zA-Z0-9_-]+)\"\>(.+)<\/A\>/", '\\4', $var);

        //URL

        $var = preg_replace("/\<A HREF=\"(.+)\" target=_blank\>(.+)\<\/A\>/", '[url=\\1]\\2[/url]', $var);

        $var = preg_replace("/\<A HREF=\"(.+)\"\>(.+)\<\/A\>/", '[url=\\1]\\2[/url]', $var);

        $var = preg_replace("/\<A HREF=\"(.+)\" target=_blank\>\\1\<\/A\>/", '[url]\\1[/url]', $var);

        //IMG

        $var = preg_replace("/\<IMG(.+)SRC=[\"\'](.+)[\"\'](.+)\>/", '[img]\\2[/img]', $var);

        //Quote \\2@\\3\\4

        $var = preg_replace("/\<BLOCKQUOTE\>(.+)\<\/BLOCKQUOTE\>/", '[quote]\\1[/quote]', $var);

        //fix line breaks

        $var = self::fix_linebreaks($var);

        return($var);
    }

    public function ubb_code($input)
    {
        if ('' == $input) {
            $input = $this->output;
        } else {
            $this->input = $input;
        }

        $var = $this->input;

        //run regular sanitizer

        $var = self::sanitize($var);

        //convert line breaks

        $var = nl2br($var);

        //B, U, I

        $var = preg_replace("/\[b\](.+)\[\/b\]/", '<b>\\1</b>', $var);

        $var = preg_replace("/\[u\](.+)\[\/u\]/", '<u>\\1</u>', $var);

        $var = preg_replace("/\[i\](.+)\[\/i\]/", '<i>\\1</i>', $var);

        //URL

        $var = preg_replace("/\[url=(.+)\](.+)\[\/url\]/", '<a href="\\1" target=_blank>\\2</a>', $var);

        $var = preg_replace("/\[url\](.+)\[\/url\]/", '<a href="\\1" target=_blank>\\1</a>', $var);

        //IMG

        $var = preg_replace("/\[img\](.+)\[\/img\]/", '<img src="\\1" border=0>', $var);

        //Email

        $var = preg_replace("/(([a-zA-Z0-9_-]+)@([a-zA-Z0-9_-]+)([\.a-zA-Z0-9_-]+))/", '<a href="mailto:\\2@\\3\\4">\\1</a>', $var);

        //Quote

        $var = preg_replace("/\[quote\](.+)\[\/quote\]/", '<blockquote>\\1</blockquote>', $var);

        //replace [br] with <br>

        $var = str_replace('[br]', '<br>', $var);

        $this->output = $var;

        return($this->output);
    }
}
