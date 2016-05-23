<?php

use Respect\Validation\Validator as v;

class Recall extends BaseModel
{
    const STATUS_ACTIVE = 1;
    const STATUS_MODERATE = 0;

    public $id;
    public $name;
    public $email;
    public $content;
    public $image;
    public $status;
    public $modified;
    public $created;
    public $updated;

    public function tableName()
    {
        return 'recalls';
    }
    
    public function safeAttributes()
    {
        return ['name', 'email', 'content'];
    }

    public function validate()
    {
        $this->name = trim(strip_tags($this->name));
        $this->email = trim(strip_tags($this->email));
        $this->content = trim(strip_tags($this->content));

        if (!v::stringType()->notEmpty()->length(4, 255)->validate($this->name))
            $this->addError('name', 'Wrong Name.');

        if (!v::stringType()->email()->notEmpty()->noWhitespace()->validate($this->email))
            $this->addError('email', 'Wrong email.');

        if (!v::stringType()->notEmpty()->validate($this->content))
            $this->addError('content', 'Wrong content.');
        
        return !$this->hasErrors();
    }

    public function save()
    {
        $this->created = date('Y-m-d H:i:s');
        $allowed = array('name','email','content','created','image');
        $sql = 'INSERT INTO ' . $this->tableName() . ' SET '.$this->pdoSet($allowed, $values, $this->getAttributes());
        $stm = self::$db->prepare($sql);
        return $stm->execute($values);
    }

    public function update()
    {
        $this->modified = 1;

        $allowed = array('name','email','content','modified');
        $sql = 'UPDATE ' . $this->tableName() . ' SET '.$this->pdoSet($allowed, $values, $this->getAttributes()). ' WHERE id = ' . $this->id;
        $stm = self::$db->prepare($sql);
        return $stm->execute($values);
    }

    public function findByPk($pk)
    {
        $model = null;
        $query = 'SELECT * FROM ' . $this->tableName() . ' WHERE id=?';

        $stmt = self::$db->prepare($query);
        $stmt->execute([$pk]);

        foreach ($stmt as $row)
        {
            $model = new self();
            $model->setAttributes($row);
            $model->id = $row['id'];
            $model->status = $row['status'];
            $model->modified = $row['modified'];
        }

        return $model;
    }
    
    public function findAll($active = true)
    {
        $models = [];
        $query = 'SELECT * FROM ' . $this->tableName();
        if ($active) {
            $query .= ' WHERE status=' . self::STATUS_ACTIVE;
        }
        $query .= ' ORDER BY created DESC';

        $stmt = self::$db->query($query);
        while ($row = $stmt->fetch())
        {
            $model = new self();
            $model->setAttributes($row);
            $model->id = $row['id'];
            $model->image = $row['image'];
            $model->created = $row['created'];
            $model->status = $row['status'];
            $model->modified = $row['modified'];
            $models[] = $model;
        }

        return $models;
    }

    public function saveImage($image)
    {
        $handle = new upload($image);
        if ($handle->uploaded) {
            $handle->file_new_name_body   = 'recall';
            $handle->allowed              = ['image/*'];
            $handle->image_resize         = true;
            $handle->image_x              = 320;
            $handle->image_y              = 240;
            $handle->image_ratio_fill     = true;
            $handle->process(BASE_PATH . '/public/uploads/');
            if ($handle->processed) {
                $handle->clean();
                return $handle->file_dst_name;
            } else {
                return '';
            }
        }
    }
    
    public function getImageSrc()
    {
        if ($this->image and is_file(BASE_PATH . '/public/uploads/'.$this->image)) {
            return '/public/uploads/'.$this->image;
        }
        
        return false;
    }
    
    public function isActivated()
    {
        return (bool) $this->status;
    }

    public static function activate($id)
    {
        $sql = 'UPDATE ' . self::model()->tableName() . ' SET status=1 WHERE id = :id';
        $stm = self::$db->prepare($sql);
        $stm->execute([':id'=>$id]);
    }

    public static function deactivate($id)
    {
        $sql = 'UPDATE ' . self::model()->tableName() . ' SET status=0 WHERE id = :id';
        $stm = self::$db->prepare($sql);
        $stm->execute([':id'=>$id]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Recall the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}