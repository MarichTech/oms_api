<?php
   defined('BASEPATH') OR exit('No direct script access allowed');

class Gen extends CI_Controller{


    public function index()
	{
        $this->load->library('word');
        //our docx will have 'lanscape' paper orientation
        $section = $this->word->createSection(array('orientation'=>'landscape'));
    
        // Add text elements
        $section->addText('Kipling Kevo!');
        $section->addTextBreak(1);

        $section->addText('I am inline styled.', array('name'=>'Verdana', 'color'=>'006699'));
        $section->addTextBreak(1);
        
        $this->word->addFontStyle('rStyle', array('bold'=>true, 'italic'=>true, 'size'=>16));
        $this->word->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>100));
        $section->addText('I am styled by two style definitions.', 'rStyle', 'pStyle');
        $section->addText('I have only a paragraph style definition.', null, 'pStyle');

        // Add image elements
        
        $section->addImage(FCPATH.'/assets/images/09.jpg', array('width'=>210, 'height'=>210, 'align'=>'center'));
        $section->addTextBreak(1);
      

        $filename='just_some_random_name.docx'; //save our document as this file name
       

        $phpWord->save("." . $path, 'Word2007', false);
        echo './downWord' . $path;

        $dir = "./word/" . $data->date;
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $path = 'name.docx';
        $phpWord->save("." . $path, 'Word2007', false);
        echo './downWord' . $path;
    

  

	}



}