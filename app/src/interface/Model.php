<?php

interface Model{
    public static function get($id, ?array $fields);
    public static function getAll();
    public static function delete($values);
    public static function insert();
    public static function update();
}
