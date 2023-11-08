<?php

namespace myClss;

class Pagination
{
    private int $per_page; #кол-во элементов на странице
    private int $total; #всего элементов
    private int $current_page = 1; #текущая отображаемая страница
    private int $pages; #всего страниц
    private int $mid_size = 2; #кол-во страниц, отображающихся в стороны от текущей
    private string $uri = ''; #ссылка на страницы пагинации

    public function __construct(int $page, int $per_page, int $total)
    {
        $this->per_page = $per_page;
        $this->total = $total;
        $this->pages = $this->getCountPages();
        $this->current_page = $this->getCurrentPage($page);
        $this->uri = $this->getUri();
    }

    private function getCountPages(): int
    {
        return ceil($this->total / $this->per_page) ?:1;
    }

    public function getStart():int
    {
        return ($this->current_page - 1) * $this->per_page;
    }

    private function getCurrentPage(int $page):int
    {
        if ($page < 1)
            return 1;
        if ($page > $this->pages)
            return $this->pages;
        return $page;
    }

    private function getUri(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0];
        if (isset($url[1]))
        {
            $uri.='?';
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (!str_contains($param, 'page='))
                {
                    $uri.=$param . '&';
                }
            }
        }
        return $uri;
    }

    public function getHtml() : string
    {
        $back = '';
        $forward = '';
        $start = '';
        $end = '';
        $left = '';
        $right = '';
        $current = $this->getPaginationButtonHtml($this->current_page, $this->current_page);

        if ($this->current_page > 1)
        {
            $back = $this->getPaginationButtonHtml($this->current_page - 1, 'Назад');
        }

        if ($this->current_page < $this->pages)
        {
            $forward = $this->getPaginationButtonHtml($this->current_page + 1, 'Вперед');
        }
        if ($this->current_page > $this->mid_size + 1)
        {
            $start = $this->getPaginationButtonHtml(1, 'Начало');
        }
        if ($this->current_page < $this->pages - $this->mid_size)
        {
            $end = $this->getPaginationButtonHtml($this->pages, 'Конец');
        }

        for ($i = $this->mid_size, $j=1; $i > 0; $i--, $j++)
        {
            if ($this->current_page - $i > 0)
                $left .= $this->getPaginationButtonHtml($this->current_page - $i, $this->current_page - $i);
            if ($this->current_page + $j <= $this->pages)
                $right .= $this->getPaginationButtonHtml($this->current_page + $j, $this->current_page + $j);
        }

        return '<nav aria-label="Page navigation example"> <ul class="pagination">' . $start . $back . $left . $current . $right . $forward . $end . '</ul></nav>';
    }

    private function getPageLink(int $page) : string
    {
        if ($page == 1)
            return rtrim($this->uri, '&?');
        if (str_contains($this->uri, '&') || str_contains($this->uri, '?'))
            return $this->uri . "page={$page}";
        return $this->uri . "?page={$page}";
    }

    private function getPaginationButtonHtml(string $page, string $value):string
    {
        if ($page == $this->current_page)
            return '<li class="page-item"><a class="page-link text-danger" href="'. $this->getPageLink($page).'">'. $value .'</a></li>';
        return '<li class="page-item"><a class="page-link" href="'. $this->getPageLink($page).'">'. $value .'</a></li>';
    }
}