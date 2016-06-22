
                <div class="form-group" style="margin-top:10px;">
                    <label for="comment">回复评论</label>
                    <textarea class="form-control" rows="3" id="comment" style="text-align:left;border:1px solid orange;-webkit-appearance: none;"><?php echo $model['oc_comment'];?></textarea>
                    <select onchange="quick();" id="quick"  class="form-control" style="margin-top:10px;border:1px solid orange;-webkit-appearance: none;">
                        <option selected="true"  value="0">快速回复</option>
                        <option value="1">感谢您对本店的支持，期待下次光临！</option>
                        <option value="2">感谢您对我们的支持，加入我们的会员即可享受特价优惠活动，随时欢迎您的光临！</option>
                        <option value="3">很抱歉出现这样的问题，下次一定改进！给您带来不便我们深表歉意，也谢谢您的谅解，祝您生活愉快！</option>
                    </select>
                </div>


            <div class="box-footer">
                <button  class="btn btn-primary btn-md col-xs-5"  onclick="updateComment('<?php echo Yii::app()->createUrl('MWeiXinEntConfig/updateComment',array('id'=>$model['id'],'new'=>$new));?>')">提交</button>
                
                 <button  class="btn btn-primary btn-md col-xs-5 pull-right" id="closebtn" onclick="closeFrame()">取消</button>
            </div>




<script type="text/javascript">
    function quick(){
        var num=$("#quick  option:selected").val();     
        if (num!=0) {
            var text=$("#quick  option:selected").text();
            $("#comment").text(text);
        }else{
            var text='';
            $("#comment").text(text);
        };
        
    }

    function updateComment(myurl){
        var loadi;
        $.ajax({
            type:'POST',
            url:myurl,
            data:{
              'c':$('#comment').val(),
            },
            async:false,
            'complete':function(){layer.close(loadi);},
            'success':function(html){
                layer.msg(html,2,1);
                window.setTimeout("closeFrame()",2000);
                window.top.location.reload();
            }
        });

    }


    function closeFrame(){
        parent.layer.close(parent.layer.getFrameIndex(window.name));
    }

</script>