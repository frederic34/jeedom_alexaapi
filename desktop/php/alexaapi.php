<?php
include_file('core', 'authentification', 'php');

if (!isConnect('admin')) {
  throw new Exception('{{401 - Refused access}}');
}

// Obtenir l'identifiant du plugin
$plugin = plugin::byId('alexaapi');
// Charger le javascript
sendVarToJS('eqType', $plugin->getId());
// Acc�der aux donn�es du plugin
$eqLogics = eqLogic::byType($plugin->getId());
?><!-- Container global (Ligne bootstrap) -->
  <div class="row row-overflow">
    <!-- Container bootstrap du menu lat�ral -->
    <div class="col-lg-2 col-md-3 col-sm-4">
      <!-- Container du menu lat�ral -->
      <div class="bs-sidebar">
        <!-- Menu lat�ral -->
        <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
        </ul>
      </div>
    </div>
	

<script>
	$('#bt_backupsZwave').on('click', function () {
		$('#md_modal2').dialog({title: "{{Génération cookie Amazon}}"});
		$('#md_modal2').load('index.php?v=d&plugin=alexaapi&modal=cookie').dialog('open');
	});
</script>


    <!-- Container des listes de commandes / �l�ments -->
    <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay">
      <legend><i class="fa fa-cog"></i> {{Gestion}}</legend>
      <div class="eqLogicThumbnailContainer">
        <!-- Bouton de scan des objets -->
      <div class="cursor" id="bt_scan" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
          <center>
            <i class="fa fa-bullseye" style="font-size : 6em;color:#94ca02;"></i>
          </center>
          <span
                  style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>{{Scan}}</center></span>
        </div>
  <div class="cursor" id="bt_sante" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
    <center>
      <i class="fa fa-medkit" style="font-size : 6em;color:#767676;"></i>
    </center>
    <span style="font-size : 1.1em;position:relative; top : 25px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Santé}}</center></span>
  </div>
        <!-- Bouton d acc�s � la configuration -->
        <div class="cursor eqLogicAction" data-action="gotoPluginConf"
             style="background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
          <center>
            <i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i>
          </center>
          <span
                  style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Configuration}}</center></span>
        </div>
      </div>
      <!-- D�but de la liste des objets -->
      <legend><i class="fa fa-table"></i> {{Mes Amazon Echo}}</legend>
      <!-- Container de la liste -->

<div class="eqLogicThumbnailContainer">
  <?php
foreach ($eqLogics as $eqLogic) {
	$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
	echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
	echo "<center>";
	$alternateImg = $eqLogic->getConfiguration('type');
	if (file_exists(dirname(__FILE__) . '/../../core/config/devices/' . $alternateImg . '.png')) {
		echo '<img class="lazy" src="plugins/alexaapi/core/config/devices/' . $alternateImg . '.png" height="105" width="105" />';
	} elseif (file_exists(dirname(__FILE__) . '/../../core/config/devices/default.png')) {
		echo '<img class="lazy" src="plugins/alexaapi/core/config/devices/default.png" height="105" width="105" />';
	} else {
		echo '<img src="' . $plugin->getPathImgIcon() . '" height="105" width="105" />';
	}
	echo "</center>";
	echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
	echo '</div>';
}
?>
</div>
</div>

	
	</div>
    <!-- Container du panneau de contr�le -->
    <div class="col-lg-10 col-md-9 col-sm-8 eqLogic"
         style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
      <!-- Bouton sauvegarder -->
      <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i>
        {{Sauvegarder}}</a>
      <!-- Bouton Supprimer -->
      <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i>
        {{Supprimer}}</a>
      <!-- Bouton configuration avanc�e -->
      <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i>
        {{Configuration avancée}}</a>
      <!-- Liste des onglets -->
      <ul class="nav nav-tabs" role="tablist">
        <!-- Bouton de retour -->
        <li role="presentation"><a class="eqLogicAction cursor" aria-controls="home" role="tab"
                                   data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a>
        </li>
        <!-- Onglet "Equipement" -->
        <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab"
                                                  data-toggle="tab"><i
                    class="fa fa-tachometer"></i> {{Equipement}}</a></li>
        <!-- Onglet "Commandes" -->
      </ul>
      <!-- Container du contenu des onglets -->
   <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
    <div role="tabpanel" class="tab-pane active" id="eqlogictab">
      <br/>
      <div class="row">
        <div class="col-sm-7">
            <form class="form-horizontal">
                <fieldset>
                                <div class="form-group">
                        <label class="col-sm-4 control-label">{{Nom de l'équipement}}</label>
                <div class="col-sm-8">
                    <span class="eqLogicAttr" data-l1key="name"></span>
                </div>
            </div>
        <!-- Onglet "Objet Parent" -->

                    <div class="form-group">
                        <label class="col-sm-4 control-label">{{Objet parent}}</label>
                        <div class="col-sm-6">
                            <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;"/>
                            <select class="eqLogicAttr form-control" data-l1key="object_id">
                                <option value="">{{Aucun}}</option>
                                <?php
foreach (object::all() as $object) {
	echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
}
?>
                           </select>
                       </div>
                   </div>
				           <!-- Cat�gorie" -->

                   <div class="form-group">
                    <label class="col-sm-4 control-label">{{Catégorie}}</label>
                    <div class="col-sm-8">
                        <?php
foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
	echo '<label class="checkbox-inline">';
	echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
	echo '</label>';
}
?>
                   </div>
               </div>
			           <!-- Onglet "Active Visible" -->

               <div class="form-group">
                <label class="col-sm-4 control-label"></label>
                <div class="col-sm-8">
                    <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
                    <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<div class="col-sm-5">
    <form class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ID}}</label>
                <div class="col-sm-8">
                    <span class="eqLogicAttr" data-l1key="logicalId"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{Type}}</label>
                <div class="col-sm-8">
                    <span class="eqLogicAttr" data-l1key="configuration" data-l2key="type"></span>
                </div>
            </div>

			        <!-- Onglet "Image" -->

            <div class="form-group">
                <div class="col-sm-10">
<center>
  <img src="core/img/no_image.gif" data-original=".jpg" id="img_device" class="img-responsive" style="max-height : 250px;"  onerror="this.src='plugins/alexaapi/core/config/devices/default.png'"/>
</center>
			            </div>
        </div>

        
    </fieldset>
</form>
</div>
</div>

<?php include_file('desktop', 'alexaapi', 'js', 'alexaapi'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
