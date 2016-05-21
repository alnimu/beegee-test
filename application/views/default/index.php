<?php
/**
 * @var Recall[] $recalls
 * @var Recall $model
 */

?>

<?php foreach ($recalls as $recall):?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <?=$recall->name?> / <?=$recall->email?>
                        <?=$recall->modified ? '(edited by Admin)' : ''?>
                    </div>
                    <div class="col-md-6 text-right">
                        <?=$recall->created;?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $imageSrc = $recall->getImageSrc();
                if (false !== $imageSrc):?>
                <img src="<?=$imageSrc?>" class="img-rounded">
                <?php endif;?>
                <?=$recall->content;?>
            </div>
            <?php if(!Application::$app->user->isGuest()):?>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?=Application::$app->createUrl('default/update', ['id' => $recall->id])?>">
                            Edit
                        </a>
                        <?php if(!$recall->isActivated()):?>
                            <a href="<?=Application::$app->createUrl('default/activate', ['id' => $recall->id])?>">
                                Activate
                            </a>
                        <?php else:?>
                            <a href="<?=Application::$app->createUrl('default/deactivate', ['id' => $recall->id])?>">
                                Deactivate
                            </a>
                        <?php endif;?>
                    </div>
                    <div class="col-md-6 text-right">
                        <?=$recall->isActivated() ? 'Activated' : 'Deactivated'?>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
<?php endforeach;?>

<?php if(Application::$app->user->isGuest()):?>

<hr>

<form class="form-horizontal" method="post" enctype="multipart/form-data">
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
        <label for="inputFile" class="col-sm-2 control-label">File input</label>
        <div class="col-sm-10">
            <input type="file" id="inputFile" accept="image/*" name="image">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Submit</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".preview-modal-lg">Preview</button>
        </div>
    </div>
</form>

<div class="modal fade preview-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="preview-name"></span> / <span class="preview-email"></span>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>
                <div class="panel-body">
                    <img src id="imageUploadPreview" style="width: 320px; height: 240px;" class="img-rounded hide">
                    <span class="preview-content"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>