<?php

return [
    'jsonSerialize' => function($paginator) {
        return [
            'page' => $paginator->page(),
            'prevPage' => $paginator->prevPage(),
            'nextPage' => $paginator->nextPage(),
            'totalPages' => $paginator->totalPages(),
            'items' => $paginator->getIterator()
        ];
    }
];