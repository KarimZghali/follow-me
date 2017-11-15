<?php

namespace FollowMeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;

class Add extends AbstractType
{
	
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
         
		
		$builder
		->add("dating_title", TextType::class, [
					"label"=>"add.title",
				"constraints"=> [
						new NotBlank([
								"message" => "add.title.error"
						])
				],
				"attr" => [
						"class" => "form-control",
						"placeholder" => "add.title.placeholder",
				]
		])
		
        
		
		->add("dating_description", TextType::class, [
					"label"=>"add.description",
				"constraints"=> [
						new NotBlank([
								"message" => "add.description.error"
						])
				],
				"attr" => [
						"class" => "form-control",
						"placeholder" => "add.description.placeholder",
				]
		])
            
        ->add("dating_start", DateTimeType::class, [
					"label"=>"add.start",
				    'format' => 'yyyy-MM-dd HH:mm',
				"constraints"=> [
						new NotBlank([
								"message" => "add.start.error"
						])
				],
				"attr" => [
						"class" => "form-control",
						"placeholder" => "add.start.placeholder",
				]
		])
        
                ->add("dating_end", TimeType::class, [
					"label"=>"add.end",
				"constraints"=> [
						new NotBlank([
								"message" => "add.end.error"
						])
				],
				"attr" => [
						"class" => "form-control",
						"placeholder" => "add.end.placeholder",
				]
		])
        
        ->add("dating_lat", TextType::class, [
					"label"=>"add.lat",
				"attr" => [
						"class" => "form-control",
						"placeholder" => "add.lat.placeholder",
				]
		])
        
        ->add("dating_lng", TextType::class, [
					"label"=>"add.lng",
				"attr" => [
						"class" => "form-control",
						"placeholder" => "add.lng.placeholder",
				]
		])
        
            ->add("dating_link_title", TextType::class, [
					"label"=>"add.link.title",
				"attr" => [
						"class" => "form-control",
						"placeholder" => "add.link.title.placeholder",
				]
		])
        
            ->add("dating_link_href", TextType::class, [
					"label"=>"add.link.href",
				"attr" => [
						"class" => "form-control",
						"placeholder" => "add.link.href.placeholder",
				]
		]);
        
       
		
	}
	
	  
	
}
