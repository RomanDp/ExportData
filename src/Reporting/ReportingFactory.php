<?php

namespace App\Reporting;

use App\Reporting\Generator\Generator;
use App\Reporting\Source\ReportSourceProvider;
use Psr\Container\ContainerInterface;

class ReportingFactory
{
    private $container;

    private $generatorsMap;

    public function __construct(ContainerInterface $container, array $generatorsMap)
    {
        $this->container = $container;
        $this->generatorsMap = $generatorsMap;
    }

    public function getGenerator(string $generatorClass): Generator
    {
        if (!isset($this->generatorsMap[$generatorClass])) {
            throw new \BadMethodCallException(
                sprintf('No generator service for "%s" generator class.', $generatorClass)
            );
        }

        return $this->container->get($this->generatorsMap[$generatorClass]);
    }

    public function getSourceProvider(string $sourceProviderClass): ReportSourceProvider
    {
        return $this->container->get($sourceProviderClass);
    }

//qsort($array);

    /*
    * Функция вычисляет количество элементов,
    * тем самым подготавливая параметры для первого запуска,
    * и запускает сам процесс.
    */

    function qsort(&$array)
    {

        $left = 0;
        $right = count($array) - 1;

        my_sort($array, $left, $right);

    }

    /*
    * Функция, непосредственно производящая сортировку.
    * Так как массив передается по ссылке, ничего не возвращает.
    */

    function my_sort(&$array, $left, $right)
    {

//Создаем копии пришедших переменных, с которыми будем манипулировать в дальнейшем.
        $l = $left;
        $r = $right;

//Вычисляем 'центр', на который будем опираться. Берем значение ~центральной ячейки массива.
        $center = $array[(int)($left + $right) / 2];

//Цикл, начинающий саму сортировку
        do {

            //Ищем значения больше 'центра'
            while ($array[$r] > $center) {
                $r--;
            }

            //Ищем значения меньше 'центра'
            while ($array[$l] < $center) {
                $l++;
            }

            //После прохода циклов проверяем счетчики циклов
            if ($l <= $r) {

                //И если условие true, то меняем ячейки друг с другом.
                list($array[$r], $array[$l]) = array($array[$l], $array[$r]);

                //И переводим счетчики на следующий элементы
                $l++;
                $r--;
            }

        //Повторяем цикл, если true
        } while ($l <= $r);

        if ($r > $left) {
            //Если условие true, совершаем рекурсию
            //Передаем массив, исходное начало и текущий конец
            my_sort($array, $left, $r);
        }

        if ($l < $right) {
            //Если условие true, совершаем рекурсию
            //Передаем массив, текущие начало и конец
            my_sort($array, $l, $right);
        }

//Сортировка завершена

    }

}
