 <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        我的评论
                    </h1>
                   
                </section>
                    
                <!-- Main content -->
                <section class="content">
				    
                    <div class="row">
					    <div class="col-md-12">
                            <div class="panel panel-default">
							    <div class="panel-heading">评论列表</div>
					     
								<ul class="list-group">
								 <?php 
  $this->renderPartial('_commentList',array(
 'dataProvider'=>$dataProvider,
 ));
 ?>
								
									 
										  
									</ul>
									
									<!-- Modal -->
									<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									  <div class="modal-dialog">
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<h4 class="modal-title" id="myModalLabel">提交回复</h4>
										  </div>
										  <div class="modal-body">
											 <textarea class="form-control" rows="3"></textarea>
										  </div>
										  <div class="modal-footer">
										    <button type="button" class="btn btn-primary">提交</button>
											<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
											
										  </div>
										</div>
									  </div>
									</div>

                            </div>   
					    </div>
					</div>
                </section><!-- /.content -->