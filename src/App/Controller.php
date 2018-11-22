<?php

namespace App\App;

use App\View\View;
use PDO;

class Controller
{
    /**
     * @return View|string
     */
    public function index()
    {
        // PDO коннект.
        $connect = Config::getInstance()->get('connect');
        // Обработка ajax запроса.
        if (isset($_POST['airport-from']) && isset($_POST['airport-to'])) {
            // По коду аэропорта получаем id.
            $airportFrom = $this->getIDAirportByCode($_POST['airport-from'], $connect);
            $airportTo = $this->getIDAirportByCode($_POST['airport-to'], $connect);
            // Подготавливаем запрос на внос данных.
            $statement = $connect->prepare("INSERT INTO `route` SET `from` = :fromAirport, `to` = :toAirport");
            $result = $statement->execute(array(
                'fromAirport' => $airportFrom,
                'toAirport' => $airportTo,
            ));
            // Проверяем на успешность.
            if ($result) {
                return '<div class="alert alert-success">Все четко</div>';
            }
            return '<div class="alert alert-danger">Все плохо</div>';
        }

        // ЛОГИКА ОТОБРАЖЕНИЯ ТАБЛИЦЫ,
        $airports = [];
        $routers = $connect->query("SELECT airoport_from.code_en AS airoport_from_en, airoport_from.code_ru AS airoport_from_ru, city_from.name AS city_from,
                                           airoport_to.code_en AS airoport_to_en, airoport_to.code_ru AS airoport_to_ru, city_to.name AS city_to
                                    FROM route AS r
                                    INNER JOIN airport AS airoport_from
                                    ON r.from = airoport_from.id
                                    INNER JOIN airport AS airoport_to
                                    ON r.to = airoport_to.id
                                    INNER JOIN city AS city_from
                                    ON airoport_from.city_id = city_from.id
                                    INNER JOIN city AS city_to
                                    ON airoport_to.city_id = city_to.id");

        // Получаем все аэропорты, и засуенем их в js, не озото ajax писать.
        $airportsStatement = $connect->query("SELECT * FROM airport");
        while ($airport = $airportsStatement->fetch()) {
            $airports[] = $airport['code_en'];
            $airports[] = $airport['code_ru'];
        }

        // Возвращаем представление и данные.
        return new View('index', [
            'title' => 'Index Page',
            'data' => $routers->fetchAll(),
            'airports' => json_encode($airports)
        ]);
    }

    /**
     * @return View
     */
    public function about()
    {
        return new View('about', ['title' => 'About page']);
    }

    /**
     * Метод поиска id аэропорта по его международному коду.
     *
     * @param $code
     * @param PDO $connect
     * @return string
     */
    private function getIDAirportByCode($code, PDO &$connect)
    {
        $statement = $connect->prepare("SELECT id 
                                        FROM `airport`
                                        WHERE `code_en` = :code
                                        OR `code_ru` = :code");
        $statement->execute(array(
            'code' => $code
        ));

        return $statement->fetchColumn();
    }
}