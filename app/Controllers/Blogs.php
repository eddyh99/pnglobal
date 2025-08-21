<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Blogs extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->blog  = model('App\Models\V1\Mdl_blogs');
    }
    
    function makeLinksClickable($text) {
        // Temporarily store existing links
        $placeholders = [];
        $text = preg_replace_callback(
            '/<a\b[^>]*>.*?<\/a>/i',
            function ($match) use (&$placeholders) {
                $key = '[[LINK_' . count($placeholders) . ']]';
                $placeholders[$key] = $match[0];
                return $key;
            },
            $text
        );
    
        // Convert http(s) links
        $text = preg_replace_callback(
            '/\bhttps?:\/\/[^\s<]+/i',
            fn($match) => '<a href="' . $match[0] . '" target="_blank" rel="noopener noreferrer">' . $match[0] . '</a>',
            $text
        );
    
        // Convert www. links
        $text = preg_replace_callback(
            '/\bwww\.[^\s<]+/i',
            fn($match) => '<a href="https://' . $match[0] . '" target="_blank" rel="noopener noreferrer">' . $match[0] . '</a>',
            $text
        );
    
        // Convert email addresses
        $text = preg_replace_callback(
            '/\b[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}\b/',
            fn($match) => '<a href="mailto:' . $match[0] . '">' . $match[0] . '</a>',
            $text
        );
    
        // Restore original links
        $text = strtr($text, $placeholders);
    
        return $text;
    }



    public function postAdd_blog(){
        $data = $this->request->getJSON();

        $mdata = [
            'link'       => $data->link,
            'title'      => $data->title,
            'content'    => $this->makeLinksClickable($data->content)
        ];
        $result = $this->blog->add($mdata);

        if (@$result->code != 201) {
			return $this->respond(error_msg($result->code, "blog", "01", $result->message), $result->code);
		}

        return $this->respond(error_msg(201, "blog", null, $result->message), 201);
    }

    public function getAll_blogs()
    {

        $result = $this->blog->all_blogs();
        return $this->respond(error_msg(200, "blogs", null, $result), 201);
    }
    
    public function getPosts_byid(){
        $id = filter_var($this->request->getVar('id'), FILTER_SANITIZE_NUMBER_INT);
        
		$result = $this->blog->post_byID($id);
        return $this->respond(error_msg(201, "message", null, $result), 200);
    }

    public function postUpdate_blog(){
        $data = $this->request->getJSON();

        $mdata = [
            'link'       => $data->link,
            'title'      => $data->title,
            'content'    => $this->makeLinksClickable($data->content)
        ];
        $result = $this->blog->edit($mdata,$data->id);

        if (@$result->code != 201) {
			return $this->respond(error_msg($result->code, "blog", "01", $result->message), $result->code);
		}

        return $this->respond(error_msg(201, "blog", null, $result->message), 201);
    }

    
}
