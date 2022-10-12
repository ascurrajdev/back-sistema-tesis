<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Notifications\WhatsappMessage;

class WhatsappMessageTest extends TestCase
{
    /**
     * @test
     */
    public function can_builder_a_message_with_a_template()
    {   
        $whatsappMessage = (new WhatsappMessage)->useTemplate()
        ->templateName('hello_world')
        ->templateLang('en_US');
        $this->assertEquals([
            'type' => 'template',
            'template' => [
                'name' => 'hello_world',
                'language' => [
                    'code' => 'en_US'
                ]
            ]
        ],$whatsappMessage->toArray());
    }

    /**
     * @test
     */
    public function can_builder_a_message_with_a_text_with_only_body()
    {   
        $whatsappMessage = (new WhatsappMessage)->useText()
        ->textBody('Hello World');
        $this->assertEquals([
            'type' => 'text',
            'text' => [
                'body' => 'Hello World',
            ]
        ],$whatsappMessage->toArray());
    }
}
