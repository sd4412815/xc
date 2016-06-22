 <div class="row">
 <div class="box box-primary col-xs-12">
    <div >
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="comment">回复评论</label>
                                            <textarea class="form-control" rows="3" class="col-xs-12" id="comment" style="text-align:left"><?php echo $model['oc_comment'];?></textarea>
                                        </div>
                                        
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button  class="btn btn-primary" onclick="updateComment('<?php echo Yii::app()->createUrl('OrderComments/updateComment',array('id'=>$model['id'],'new'=>$new));?>')">提交</button>
                                         <button  class="btn btn-primary" id="closebtn" onclick="closeFrame()">取消</button>
                                    </div>
                                </div>
                            </div><!-- /.box -->
</div>
