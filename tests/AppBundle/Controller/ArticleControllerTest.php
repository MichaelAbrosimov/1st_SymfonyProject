<?php
/**
 * Перед тестированием
 * загрузить фикстуру
 *
 * LoadArticleData.php
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;

class ArticleControllerTest extends WebTestCase
{
    /**
     * @var
     */
    public static $application;

    /**
     * @param $command
     *
     * @return int
     */
    public static function runAppConsoleCommand($command)
    {
       // $command = sprintf('%s --env=test', $command);
        return self::getApplication()->run(new StringInput($command));
    }
    public static function setUpBeforeClass()
    {
        self::setUpMysql();
    }
    /**
     * @return Application
     */
    public static function getApplication()
    {
        if (null === self::$application) {
            self::$application = new Application(static::createClient()->getKernel());
            self::$application->setAutoExit(false);
        }
        return self::$application;
    }
    /**
     * @return void
     */
    public static function setUpMysql()
    {
      //  self::runAppConsoleCommand('doctrine:database:drop --force');
      //  self::runAppConsoleCommand('doctrine:database:create');
        self::runAppConsoleCommand('doctrine:schema:update --force --verbose=3');
        self::runAppConsoleCommand('doctrine:fixtures:load -q --verbose=3');
    }

    /**
     * В таблице 2 записи: t1, t2
     */
    public function testIndexAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/article');

        //Есть надпись "Article" в заголовке таблицы
        $this->assertContains('Article', $crawler->filter('body > table > caption')->text());

        //Есть надписи: "Имя" "Описание" "Дата создания" "Удалить" в заголовке таблицы
        $this->assertContains('Имя', $crawler->filter('body > table > thead')->text());
        $this->assertContains('Описание', $crawler->filter('body > table > thead')->text());
        $this->assertContains('Дата создания', $crawler->filter('body > table > thead')->text());
        $this->assertContains('Удалить', $crawler->filter('body > table > thead')->text());

        //В теле таблицы ровно 2 строки и 8 ячеек
        $this->assertCount(2, $crawler->filter('body > table > tbody> tr'));
        $this->assertCount(8, $crawler->filter('body > table > tbody> tr > td'));
    }


    /**
     * Добавляем t3
     */
    public function testCreateAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article');

        $linkCreate = $crawler->filter('body > a > input')//находим кнопку создать
                                ->parents()
                                ->link();
        $crawler = $client->click($linkCreate); //вызываем форму Create
        $form = $crawler->selectButton('Submit')->form();
        $form['article_form[name]'] = 't3';
        $form['article_form[description]'] = 'test3';
        $crawler = $client->submit($form);   // submit
        $this->assertTrue(
            $client->getResponse()->isRedirect('/article')); //submit redirect to /article

        $crawler = $client->request('GET', '/article'); //????почему-то приходится все равно вызывать

        //В теле таблицы ровно 3 строки и 12 ячеек
        $this->assertCount(3, $crawler->filter('body > table > tbody> tr'));
        $this->assertCount(12, $crawler->filter('body > table > tbody> tr > td'));

        // в таблице есть "t3" и "test3";
        $this->assertContains('t3', $crawler->filter('body > table > tbody')->text());
        $this->assertContains('test3', $crawler->filter('body > table > tbody')->text());
    }

    /**
     * Изменяем t3 на t4
     */
    public function testUpdateAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article');
        $linkUpdate = $crawler->filter('a:contains("t3")')
            ->link();
        $crawler = $client->click($linkUpdate); //вызываем Update;

        $form = $crawler->selectButton('Submit')->form();
        $form['article_form[name]'] = 't4';
        $form['article_form[description]'] = 'test4';
        $crawler = $client->submit($form);   // submit

        $this->assertTrue(
            $client->getResponse()->isRedirect('/article')); //submit redirect to /article

        $crawler = $client->request('GET', '/article'); //????почему-то приходится все равно вызывать

        //В теле таблицы ровно 3 строки и 12 ячеек
        $this->assertCount(3, $crawler->filter('body > table > tbody> tr'));
        $this->assertCount(12, $crawler->filter('body > table > tbody> tr > td'));

        // в таблице есть "t4" и "test4";
        $this->assertContains('t4', $crawler->filter('body > table > tbody')->text());
        $this->assertContains('test4', $crawler->filter('body > table > tbody')->text());
    }

    /**
     * Удаление t4
     */
    public function testDeleteAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article');

        $linkCreate = $crawler->filter('a:contains("t4")')
                        ->parents()
                        ->filter('a:contains("X")')
                        ->link();
        $crawler = $client->click($linkCreate); //вызываем Delete;
        $this->assertTrue(
            $client->getResponse()->isRedirect('/article'));

        $crawler = $client->request('GET', '/article');  //????почему-то приходится все равно вызывать

        //В теле таблицы ровно 2 строки и 8 ячеек
        $this->assertCount(2, $crawler->filter('body > table > tbody> tr'));
        $this->assertCount(8, $crawler->filter('body > table > tbody> tr > td'));

        // в таблице нет "t4" и нет "test4";
        $this->assertNotContains('t4', $crawler->filter('body > table > tbody')->text());
        $this->assertNotContains('test4', $crawler->filter('body > table > tbody')->text());
    }
}
