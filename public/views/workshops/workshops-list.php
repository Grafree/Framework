<?php self::_render( 'components/page-header', [ 'title' =>'Formations' ] ); ?>

<div class="row">
    <div class="col-md-12">
    
        <?php self::_render( 'components/tabs-toolsheader', [ 
                                'tabs'=>$datas->tabs
                            ] ); ?>
        <section>
            <?php self::_render( 'components/section-toolsheader', [ 
                                'title' => 'Formations',
                                'subtitle' => ' - '.( $datas->datas->nbAteliers ).' formations(s)', 
                                'tool-add' => true,
                                'tool-add-right' => 'add',
                                'tool-add-url' => '/workshops/workshopform/',
                                'tool-add-label' => 'Ajouter un atelier',
                                'rightpage' => 'users',
                                'response' => $datas->response,
                                'tool-dropdown' => true,
                                'tool-dropdown-list' => $datas->dropdownlist, 
                                /* 'tool-custom' => '<li><a class="collapse-link btn btn-info" href="'.SITE_URL . '/workshops/subscribe/"><i class="mdi mdi-presentation-play"></i> Planifier un atelier</a></li>'*/
                            ] ); ?>
            
            <div class="body-section"> 
                
            <?php
            if( isset( $datas->datas->all ) )
            {
                foreach( $datas->datas->all as $n => $domain )
                {                       
                    if( isset( $domain->workshops ) )
                    {
                        ?><h4><?php echo $domain->NomDomaine.' ('.$domain->nbAteliers.' ateliers)' ?></h4><?php 

                        foreach( $domain->workshops as $n => $data )
                        { 
                            $toolsInfos = '';

                            ?>
                            <section class="profile clearfix">
                                <?php self::_render( 'components/section-toolsheader', [ 
                                                    'title' => '<a href="'.SITE_URL.'/workshops/detail/'.$data->IdWorkshop.'">'.$data->TitleWorkshop.'</a>',
                                                    'subtitle' => '', 
                                                    'tool-update' => true,
                                                    'tool-update-url' => '/workshops/workshopform/' . $data->IdWorkshop,
                                                    'tool-delete' => true,
                                                    'tool-delete-url' => '/workshops/workshopdelete/' . $data->IdWorkshop,
                                                    'tool-delete-display' => !$data->infos['hasDependencies'],
                                                    'tool-minified' => true, 
                                                    'tool-custom' => $toolsInfos,
                                                    'rightpage'=>'users',
                                                    'alertbox-display' => false
                                                ] ); ?>

                                    <div class="minified">

                                        <?php self::_render( 'workshops/workshop-details', $data ); ?>

                                    </div>
                            </section>
                            <?php
                        }
                        ?>

                        <hr />

                        <?php
                    }
                }
            }
            else
            {
                ?>
                <p class="alert alert-info">Aucun domaine trouvé !</p>
                <?php
            }
        ?>
        </div>
                    
                    
<?php self::_render( 'components/window-modal', [ 
                            'idname'=>'delete', 
                            'title'=>'Suppression d\'un atelier', 
                            'content'=>'Etes-vous sûr de vouloir supprimer un atelier ?', 
                            'submitbtn' => 'Supprimer' 
                        ] ); ?>
        </section>
    </div>
</div>