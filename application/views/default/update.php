<?php
/**
 * @var Recall $model
 */
?>

<form class="form-horizontal" method="post" action="<?=Application::$app->createUrl('default/update', ['id' => $model->id])?>">
    <div class="form-group<?=$model->hasError('name')?' has-error':''?>">
        <label for="inputName" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="inputName" data-change-target=".preview-name" placeholder="Name" name="recall[name]" value="<?=$model->name?>">
            <?php if ($model->hasError('name')):?>
                <p class="help-block"><?=$model->getError('name')?></p>
            <?php endif;?>
        </div>
    </div>
    <div class="form-group<?=$model->hasError('email')?' has-error':''?>">
        <label for="inputEmail" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail" data-change-target=".preview-email" placeholder="Email" name="recall[email]" value="<?=$model->email?>">
            <?php if ($model->hasError('email')):?>
                <p class="help-block"><?=$model->getError('email')?></p>
            <?php endif;?>
        </div>
    </div>
    <div class="form-group<?=$model->hasError('content')?' has-error':''?>">
        <label for="inputContent" class="col-sm-2 control-label">Content</label>
        <div class="col-sm-10">
            <textarea class="form-control" id="inputContent" data-change-target=".preview-content" placeholder="Content" name="recall[content]" style="resize: vertical;" rows="3"><?=$model->content?></textarea>
            <?php if ($model->hasError('content')):?>
                <p class="help-block"><?=$model->getError('content')?></p>
            <?php endif;?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Submit</button>
            <a href="<?=Application::$app->createUrl('default/index')?>" class="btn btn-primary">Back</a>
        </div>
    </div>
</form>
