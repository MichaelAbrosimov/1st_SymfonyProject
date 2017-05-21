<?php
/**
 * Перед тестированием
 * загрузить фикстуру
 *
 * LoadArticleData.php
 */

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article');

        //Есть надпись "Article" в заголовке таблицы
        $this->assertContains('Article', $crawler->filter('body > table > caption ')->text());

        //Есть надписи: "Имя" "Описание" "Дата создания" "Удалить" в заголовке таблицы
        $this->assertContains('Имя', $crawler->filter('body > table > thead ')->text());
        $this->assertContains('Описание', $crawler->filter('body > table > thead ')->text());
        $this->assertContains('Дата создания', $crawler->filter('body > table > thead ')->text());
        $this->assertContains('Удалить', $crawler->filter('body > table > thead ')->text());

        //В теле таблицы ровно 2 строки и 8 ячеек
        $this->assertCount(2, $crawler->filter('body > table > tbody> tr'));
        $this->assertCount(8, $crawler->filter('body > table > tbody> tr > td'));
    }

 /**
    public function testCreateAction()
    {

    }
    public function testUpdateAction()
    {

    }
    public function testDeleteAction()
    {

    }
  */
}
