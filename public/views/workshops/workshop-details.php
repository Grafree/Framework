<div class="col-md-3 col-sm-3 col-xs-12">
    <ul class="list-unstyled user_data">
    <?php echo ( !empty( $datas->length ) )              ? '<li><i class="mdi mdi-calendar-clock"></i>Durée&nbsp;: '.$datas->length.'</li>'                                       : ''; ?>
    <?php echo ( !empty( $datas->PlaceWorkshop ) )        ? '<li><i class="mdi mdi-map-marker"></i>Lieu&nbsp;: '.$datas->PlaceWorkshop . '</li>'                                : ''; ?>
    <?php echo ( !empty( $datas->LastnameCoach ) )        ? '<li><i class="mdi mdi-account"></i>Coordinateur&nbsp;: '.$datas->FirstnameCoach.' '.$datas->LastnameCoach.'</li>'  : ''; ?>
    <?php //echo ( isset( $datas->type ) )                 ? '<li><i class="mdi mdi-label-outline"></i>Type&nbsp;: '.$datas->type.'</li>'                                          : ''; ?>
    
    <li>
    <a class="btn btn-default" href="<?php echo SITE_URL; ?>/workshops/subscribe/<?php echo $datas->IdWorkshop; ?>"><i class="mdi mdi-account-check"></i>Inscription</a><br />
    </li>
        
    <?php echo ( !empty( $datas->DescriptionWorkshop ) ) ? '<li><i class="mdi mdi-comment-outline"></i><strong>Description</strong>&nbsp;: '.$datas->DescriptionWorkshop.'</li>'   : ''; ?>
    <?php echo ( !empty( $datas->PrerequisWorkshop ) )   ? '<li><i class="mdi mdi-comment-outline"></i><strong>Prérequis</strong>&nbsp;: '.$datas->PrerequisWorkshop.'</li>'       : ''; ?>
    <?php echo ( !empty( $datas->RemarquesWorkshop ) )   ? '<li><i class="mdi mdi-comment-outline"></i><strong>Description</strong>&nbsp;: '.$datas->RemarquesWorkshop.'</li>'     : ''; ?>
    </ul>
</div>

<?php
if( isset( $datas->users ) )
{
?>
<div class="col-md-9 col-sm-9 col-xs-12">

    <table class="table profile_table">
        <tr class="cell-h1">
            <th>Nom</th>
            <th>Evaluation</th>
        </tr>
        <?php
        foreach( $datas->users as $user )
        {
            ?>
            <tr>
                <td><?php echo $user->LastnameUser.' '.$user->FirstnameUser; ?></td>
                <td>
                    
                    
                    <?php 
                    if( !empty( $user->IsEvalUserWorkshop ) )
                    {
                        ?>
                        <a href="<?php echo SITE_URL; ?>/workshops/evalresults/<?php echo $user->IdUserWorkshop; ?>"><span title="Consulter l'évaluation" class="mdi mdi-file-chart"></span></a>
                        <?php
                    }
                    else
                    {
                        ?>
                        <a href="<?php echo SITE_URL; ?>/login/eval/<?php echo $user->loginUrl; ?>"><span title="Accéder au formulaire (simulation)" class="mdi mdi-tooltip-edit"></span></a>
                        <a href="<?php echo SITE_URL; ?>/workshops/evalsendinvite/<?php echo $user->IdUserWorkshop; ?>"><span title="Envoyer l'invitation" class="mdi mdi-email"></span></a>
                        <?php
                    }
                    ?>
                </td>
            </tr>    
            <?php
        }
        ?>
    </table>
</div>
<?php
}
?>