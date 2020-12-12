<?php
declare(strict_types=1);

namespace SimpleMVC\Model;

use PDO;
use SimpleMVC\Exception\DuplicateEntryException;

class Task extends BaseModel
{
     /**
     * @param array $data
     * @param string $nicknam
     * @return bool
     */
    public function insertOne(array $data, string $nickname) : bool
    {
        return $this->insert('tasks', [
            'columns' => ['content', 'title', 'insertion_time', 'user'],
            'bind' => [
                'content' => $data['content'],
                'title' => $data['title'],
                'insertion_time' => date('Y-m-d H:i:s'),
                'user' => $nickname
            ]
        ]);
    }

    /**
     * @param string $nickname
     * @return array
     */
    public function findAll(string $nickname) : array
    {
        $tasks = $this->find(
            'tasks', [
                'conditions' => 'user = :nickname',
                'order' => 'insertion_time',
                'bind' => [
                    ':nickname' => $nickname
                ]
            ]
        );

        if(empty($tasks)) {
            return [];
        }

        return $tasks;
    }

    /**
     * @param array $data
     * @param string $nickname
     * @return bool
     */
    public function updateOne(array $data, string $nickname) : bool
    {
        return $this->update(
            'tasks', [
                'set' => [
                    'title = :title',
                    'content = :content'
                ],
                'conditions' => 'user = :nickname AND id = :id',
                'bind' => [
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'id' => $data['id'],
                    'nickname' => $nickname
                ]
            ]
        );
    }

    /**
     * @param int $id
     * @param string $nickname
     * @return bool
     */
    public function deleteOne(int $id, string $nickname) : bool
    {
        return $this->delete(
          'tasks', [
              'conditions' => 'user = :nickname AND id = :id',
              'bind' => [
                  'id' => $id,
                  'nickname' => $nickname
              ]
          ]
        );
    }
}