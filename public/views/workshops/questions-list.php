<?php self::_render( 'components/page-header', [ 'title' =>'Questions' ] ); ?>

<div class="row">
    <div class="col-md-12">
    
        <?php self::_render( 'components/tabs-toolsheader', [ 
                                'tabs'=>$datas->tabs
                            ] ); ?>
        <section>
            <?php self::_render( 'components/section-toolsheader', [ 
                                'title' => 'Questions',
                                'subtitle' => '', 
                                'tool-add' => true,
                                'tool-add-right' => 'add',
                                'tool-add-url' => '/workshops/questionform/',
                                'tool-add-label' => 'Ajouter une question',
                                'rightpage' => 'users',
                                'response' => $datas->response
                            ] ); ?>
            
            <div class="body-section"> 
                
            <?php
            if( isset( $datas->datas ) )
            {
                foreach( $datas->datas as $n => $data )
                {       
                    ?>
                    <section class="profile clearfix">
                        <?php self::_render( 'components/section-toolsheader', [ 
                                            'title' => ''.$data->Question.'</a>',
                                            'subtitle' => '', 
                                            'tool-update' => true,
                                            'tool-update-url' => '/workshops/questionform/' . $data->IDQuestion,
                                            'tool-delete' => true,
                                            'tool-delete-url' => '/workshops/questiondelete/' . $data->IDQuestion,
                                            'tool-delete-display' => !$data->infos['hasDependencies'],
                                            'rightpage'=>'users',
                                            'alertbox-display' => false
                                        ] ); ?>

                    </section>
                    <?php
                }
            }
            else
            {
                ?>
                <p class="alert alert-info">Aucune question trouvée !</p>
                <?php
            }
        ?>
        </div>
                    
                    
<?php self::_render( 'components/window-modal', [ 
                            'idname'=>'delete', 
                            'title'=>'Suppression d\'une question', 
                            'content'=>'Etes-vous sûr de vouloir supprimer une question ?', 
                            'submitbtn' => 'Supprimer' 
                        ] ); ?>
        </section>
    </div>
</div>