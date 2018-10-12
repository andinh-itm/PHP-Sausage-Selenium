<?php
require_once 'vendor/autoload.php';
class MyAwesomeTestCase extends Sauce\Sausage\WebDriverTestCase
{
    protected $start_url = 'https://test-it.drupal.gwu.edu';
    public static $browsers = array(
        array(
            'browserName' => 'chrome',
            'desiredCapabilities' => array(
                'version' => '45.0',
                'platform' => 'OS X 10.10'
            )
        )
    );
    public function testTitle()
    {
        $this->assertContains("Division of IT | The George Washington University", $this->title());
    }
    public function testTextbox()
    {
        $test_text = "This is some text";
        $textbox = $this->byId('edit-search-keys');
        $textbox->click();
        $textbox->clear();
        $this->keys($test_text);
        $this->assertEquals($textbox->value(), $test_text);
    }
    public function testSubmitComments()
    {
        $comment = "Hello";
        $this->byId('edit-search-keys')->value($comment);
        $this->byId('edit-submit')->submit();
        $driver = $this;
        $comment_test = function() use ($comment, $driver) {
            $text = $driver->byId('searchblox-search-form--2')->text();
            return $text == "$comment";
        };
        $this->assertEquals('Search this site | Division of IT | The George Washington University', $this->title());
//        $this->spinAssert("Comment never showed up!", $comment_test);
    }
}
