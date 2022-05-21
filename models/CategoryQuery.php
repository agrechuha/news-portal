<?php

namespace app\models;

use paulzi\adjacencyList\AdjacencyListQueryTrait;

class CategoryQuery extends \yii\db\ActiveQuery
{
    use AdjacencyListQueryTrait;
}
