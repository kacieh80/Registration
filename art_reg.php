<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('class.RegisterWizardPage.php');
$page = new RegisterWizardPage('Art Project');

$page->addWellKnownJS(JS_BOOTBOX, false);
$page->addJS('js/reg.js');
$page->addJS('js/art_reg.js');

$index = $page->add_wizard_step('Basic Questions');
$page->add_form_group($index, 'This project needs logistical help', 'need_logistics', 'checkbox', 'This project has logistical needs such as needing help transporting to the site, heavy equipment needs, outside volunteers etc.', array('class'=>'ignore', 'data-tabcontrol'=>'logistics'));
$page->add_spacer($index);
$page->add_form_group($index, 'This project has sound', 'has_sound', 'checkbox', 'This project will utilize amplified sound in some form.', array('class'=>'ignore', 'data-tabcontrol'=>'sound'));
$page->add_spacer($index);
$page->add_form_group($index, 'This project has flame effects', 'has_fe', 'checkbox', 'This project has flame effects (propane or other combustable non-consuming effects).', array('class'=>'ignore', 'data-tabcontrol'=>'fire', 'data-questcontrol'=>'fire_flameEffects'));
$page->add_spacer($index);
$page->add_form_group($index, 'I would like to burn this project', 'will_burn', 'checkbox', 'This project has flame effects or I would like to burn this piece.', array('class'=>'ignore', 'data-tabcontrol'=>'fire', 'data-questcontrol'=>'fire_burnPlan'));
$page->add_spacer($index);

$index = $page->add_wizard_step('Images');
$page->add_form_group($index, 'Image #1', 'image_1', 'file', 'A picture or drawing of your art.');
$page->add_spacer($index);
$page->add_form_group($index, 'Image #2', 'image_2', 'file', 'A picture or drawing of your art.');
$page->add_spacer($index);
$page->add_form_group($index, 'Image #3', 'image_3', 'file', 'A picture or drawing of your art.');
$page->add_spacer($index);

$index = $page->add_wizard_step('Art Team Contacts');
$accordion_ref = $page->add_accordion($index);
$panels = array('Art Lead', 'Safety Lead', 'Cleanup Lead', 'Fire Lead', 'Sound Lead');
$all_panels = array(
    array('label'=>'Name:', 'name'=>'name', 'type'=>'text', 'tooltip'=>'This is the name of the %s', 'required'=>TRUE),
    array('label'=>'Burner Name:', 'name'=>'burnerName', 'type'=>'text', 'tooltip'=>'This is the burner name/nickname of the %s'),
    array('label'=>'Email:', 'name'=>'email', 'type'=>'text', 'tooltip'=>'This is the email address of the %s', 'required'=>TRUE),
    array('label'=>'Phone:', 'name'=>'phone', 'type'=>'text', 'tooltip'=>'This is the phone number of the %s', 'required'=>TRUE),
    array('label'=>'This number can receive SMS messages:', 'name'=>'sms', 'type'=>'checkbox', 'tooltip'=>'This phone number can be used to recieve text messages'),
    array('label'=>'Theme Camp Affiliation:', 'name'=>'camp', 'type'=>'text', 'tooltip'=>'The Theme Camp where %s will camp.', 'required'=>TRUE),
);
$other = array(
    'Art Lead' => array('label'=>'The project lead is the only contact', 'id'=>'just_me', 'name'=>'just_me', 'type'=>'checkbox', 'tooltip'=>'The project lead will be contact for all issues about the project including safety, cleanup, volunteering, and sound.'),
);
$panel_count = count($panels);
$content_count = count($all_panels);
for($i = 0; $i < $panel_count; $i++)
{
    $panel_ref = $page->add_accordion_panel($accordion_ref, $panels[$i]);
    $camel = camelize($panels[$i]);
    $lower = strtolower($panels[$i]);
    for($j = 0; $j < $content_count; $j++)
    {
        $tooltip = sprintf($all_panels[$j]['tooltip'], $lower);
        if(isset($all_panels[$j]['required']))
        {
            $extra = array('required'=>$all_panels[$j]['required']);
        }
        else
        {
            $extra = FALSE;
        }
        if($i > 0)
        {
            if($extra === FALSE)
            {
                $extra = array();
            }
            $extra['data-copyfrom'] = camelize($panels[0]).'_'.$all_panels[$j]['name'];
            $extra['data-copytrigger'] = '#artLead_just_me';
        }
        else
        {
            if($all_panels[$j]['name'] === 'email')
            {
                if($extra === FALSE)
                {
                    $extra = array();
                }
                $extra['disabled'] = true;
            }
        }
        $page->add_form_group($panel_ref, $all_panels[$j]['label'], $camel.'_'.$all_panels[$j]['name'], $all_panels[$j]['type'], $tooltip, $extra);
        $page->add_spacer($panel_ref);
    }
    if(isset($other[$panels[$i]]))
    {
        $tooltip = sprintf($other[$panels[$i]]['tooltip'], $lower);
        if(isset($other[$panels[$i]]['required']))
        {
            $extra = array('required'=>$other[$panels[$i]]['required']);
        }
        else
        {
            $extra = FALSE;
        }
        $page->add_form_group($panel_ref, $other[$panels[$i]]['label'], $camel.'_'.$other[$panels[$i]]['name'], $other[$panels[$i]]['type'], $tooltip, $extra);
        $page->add_spacer($panel_ref);
    }
}


$index = $page->add_wizard_step('Placement Information');
$page->add_raw_html($index, '<div class="alert alert-info" role="alert"><span class="fa fa-bed" aria-hidden="true"></span> If this piece is to be placed with your theme camp, be sure it\'s footprint is included on the theme camp registration form <a href="add.php" class="alert-link" target="_blank">here</a>.</div>');

$page->add_raw_html($index, '<div class="embed-responsive embed-responsive-4by3">
  <object class="embed-responsive-item" type="application/pdf" data="img/guide_map16a.pdf">
      <p>
          <img src="img/guide_map16a.png" class="img-responsive"/>
          Sorry, your browser is unable to display the full res map in line. Click <a href="img/guide_map16a.pdf">here</a> to download it
      </p>
  </object>
</div>');

$page->add_form_group($index, 'Show on map:', 'placement_on_map', 'checkbox', 'Check this box if you want your art installation to be shown on city planning map.');
$page->add_spacer($index);

$page->add_form_group($index, 'In Theme Camp:', 'placement_in_camp', 'text', 'If your art will be placed within the borders of a theme camp enter the camp name here.');
$page->add_spacer($index);

$page->add_form_group($index, 'Dimensions (in feet):', 'placement_size', 'text', 'Approximate project dimensions, in feet* [width / length / height]');
$page->add_spacer($index);
$options = array(
    array('value'=>'any', 'text'=>'Any', 'selected'=>TRUE),
    array('value'=>'corral', 'text'=>'Corral'),
    array('value'=>'crossroads', 'text'=>'Cross roads'),
    array('value'=>'effigy', 'text'=>'Effigy Field'),
    array('value'=>'island', 'text'=>'Island'),
    array('value'=>'onRoad', 'text'=>'Along a Roadway'),
    array('value'=>'riverwalk', 'text'=>'Riverwalk'),
    array('value'=>'ownCamp', 'text'=>'Own Themecamp'),
    array('value'=>'otherCamp', 'text'=>'Other Themecamp')
);
$page->add_form_group($index, 'Preference 1:', 'placement_pref1', 'select', 'Your first choice for a general type of placement.', array('options'=>$options));
$page->add_spacer($index);
$page->add_form_group($index, 'Preference 2:', 'placement_pref2', 'select', 'Your second choice for a general type of placement.', array('options'=>$options));
$page->add_spacer($index);
$page->add_form_group($index, 'Preference 3:', 'placement_pref3', 'select', 'Your third choice for a general type of placement.', array('options'=>$options));
$page->add_spacer($index);
$page->add_form_group($index, 'Preference Description:', 'placement_desc', 'textarea', 'Describe your ideal installation spot.');
$page->add_spacer($index);

$index = $page->add_wizard_step('Logistics Information', 'logistics');
$page->add_form_group($index, 'I need help transporting this project to Flipside', 'logistics_needsTranspo', 'checkbox', 'I need help transporting this project to Burning Flipside.', array('data-questcontrol'=>'logistics_transpoSize'));
$page->add_spacer($index);
$page->add_form_group($index, 'What are the packed dimensions and the weight of the project', 'logistics_transpoSize', 'textarea');
$page->add_spacer($index);
$page->add_form_group($index, 'I will need help from the heavy equipment on site', 'logistics_needsHE', 'checkbox', 'I will need use of the Variable Reach forklift, Trencher, Cherry Picker, or other Heavy Equipment on site if available.', array('data-questcontrol'=>'logistics_descHE'));
$page->add_spacer($index);
$page->add_form_group($index, 'Please describe what Heavy Equipment you will need, what it needs to do, and how long you think you will need it for', 'logistics_descHE', 'textarea');
$page->add_spacer($index);
$page->add_form_group($index, 'I will need help from volunteers other than the crew I can bring', 'logistics_needsVols', 'checkbox', 'I will need help from Flipside volunteers such as Shaven Apes to help assemble, Fire Team, or other volunteers.', array('data-questcontrol'=>'logistics_descVols'));
$page->add_spacer($index);
$page->add_form_group($index, 'Please describe what volunteers you will need, what you need them to do, and for how long you will need them', 'logistics_descVols', 'textarea');
$page->add_spacer($index);

$index = $page->add_wizard_step('Sound', 'sound');
$page->add_form_group($index, 'Sound System Description', 'sound_desc', 'textarea', 'Describe your sound equipment and how you plan to adhere to the Event Sound Policy');
$page->add_spacer($index);
$options = array(
    array('value'=>'', 'text'=>'', 'selected'=>TRUE),
    array('value'=>'all', 'text'=>'All Day'),
    array('value'=>'0100', 'text'=>'1 AM'),
    array('value'=>'0200', 'text'=>'2 AM'),
    array('value'=>'0300', 'text'=>'3 AM'),
    array('value'=>'0400', 'text'=>'4 AM'),
    array('value'=>'0500', 'text'=>'5 AM'),
    array('value'=>'0600', 'text'=>'6 AM'),
    array('value'=>'0700', 'text'=>'7 AM'),
    array('value'=>'0800', 'text'=>'8 AM'),
    array('value'=>'0900', 'text'=>'9 AM'),
    array('value'=>'1000', 'text'=>'10 AM'),
    array('value'=>'1100', 'text'=>'11 AM'),
    array('value'=>'1200', 'text'=>'Noon'),
    array('value'=>'1300', 'text'=>'1 PM'),
    array('value'=>'1400', 'text'=>'2 PM'),
    array('value'=>'1500', 'text'=>'3 PM'),
    array('value'=>'1600', 'text'=>'4 PM'),
    array('value'=>'1700', 'text'=>'5 PM'),
    array('value'=>'1800', 'text'=>'6 PM'),
    array('value'=>'1900', 'text'=>'7 PM'),
    array('value'=>'2000', 'text'=>'8 PM'),
    array('value'=>'2100', 'text'=>'9 PM'),
    array('value'=>'2200', 'text'=>'10 PM'),
    array('value'=>'2300', 'text'=>'11 PM'),
    array('value'=>'0000', 'text'=>'Midnight')
);
$page->add_form_group($index, 'Sound Hours - From:', 'sound_from', 'select', 'When will you start sound on your project.', array('options'=>$options));
$page->add_spacer($index);
$page->add_form_group($index, 'Sound Hours - To:', 'sound_to', 'select', 'When will you stop sound on your project.', array('options'=>$options));
$page->add_spacer($index);

$index = $page->add_wizard_step('Fire', 'fire');

$page->add_form_group($index, 'This project has fire effects', 'fire_hasFlameEffects', 'checkbox', '', array('data-questcontrol'=>'fire_flameEffects'));
$page->add_spacer($index);
$page->add_form_group($index, 'Flame Effects Description', 'fire_flameEffects', 'textarea', 'Describe any flame effects such as propane or other flame effects that do not consume your artwork.');
$page->add_spacer($index);

$options = array(
    array('value'=>'', 'text'=>'', 'selected'=>TRUE),
    array('value'=>'thrusday', 'text'=>'Thursday'),
    array('value'=>'friday', 'text'=>'Friday'),
    array('value'=>'saturday', 'text'=>'Saturday'),
    array('value'=>'sunday', 'text'=>'Sunday')
);
$page->add_form_group($index, 'When do you want to burn?', 'fire_burnDay', 'select', 'When do you plan to burn your project.', array('options'=>$options, 'required'=>TRUE));
$page->add_spacer($index);
$page->add_form_group($index, 'Burn Plan', 'fire_burnPlan', 'textarea', 'Describe how you anticipate burning your art project. Describe what fuel you would use, any pyrotechic effects, when you would enact perimeter, and any other special considerations the fire team would need to know about.', array('required'=>TRUE));
$page->add_spacer($index);
$page->add_form_group($index, 'Cleanup Plan', 'fire_cleanupPlan', 'textarea', 'Describe how you anticipate cleaning your art project after burning.', array('required'=>TRUE));
$page->add_spacer($index);

$index = $page->add_wizard_step('Installation Information');
$page->add_form_group($index, 'Art Removal or UnBurn Plan', 'information_unburn', 'textarea', 'Describe how you intend to remove your project after the event. Please note that "We will burn it." is not an acceptible plan as we may have a burn ban or other reasons why your piece cannot burn.', array('required'=>TRUE));
$page->add_spacer($index);
$page->add_form_group($index, 'Setup/teardown time and requirements', 'information_setup', 'textarea', 'Describe how much time you will need to setup/teardown this project and any special requirements you may have.', array('required'=>TRUE));
$page->add_spacer($index);
$options = array(
    array('value'=>'', 'text'=>'', 'selected'=>TRUE),
    array('value'=>'thrusday', 'text'=>'Thursday'),
    array('value'=>'friday', 'text'=>'Friday'),
    array('value'=>'saturday', 'text'=>'Saturday'),
    array('value'=>'sunday', 'text'=>'Sunday')
);
$page->add_form_group($index, 'Arrival at Flipside:', 'information_arrival', 'select', 'When do you plan to arrive at Flipside.', array('options'=>$options, 'required'=>TRUE));
$page->add_spacer($index);
$page->add_form_group($index, 'This project requires a generator', 'information_power', 'checkbox', 'This project will use a generator.', array('data-questcontrol'=>'information_powerStats'));
$page->add_spacer($index);
$page->add_form_group($index, 'Power Requirements/Generator Information', 'information_powerStats', 'textarea', 'Please describe your power needs. And if you are bringing a generator and are interested in power sharing describe how much available power you will have.');
$page->add_spacer($index);

$page->add_form_group($index, 'This project includes lasers', 'information_laser', 'checkbox', 'This project will use lasers.', array('data-questcontrol'=>'information_laserStats'));
$page->add_spacer($index);
$page->add_form_group($index, 'Laser installation details', 'information_laserStats', 'textarea', 'Tell us about your lasers. What kind? How high will they be mounted?');
$page->add_spacer($index);

$page->add_form_group($index, 'Other Information', 'information_other', 'textarea', 'Please tell us ANYTHING that we may have missed');
$page->add_spacer($index);

if(isset($_GET['is_admin']))
{
    $user = $page->user;
    if($user->isInGroupNamed('RegistrationAdmins') || $user->isInGroupNamed('ArtAdmins'))
    {
        $index = $page->add_wizard_step('Admin Data');
        $page->add_form_group($index, 'Placement ID:', 'location', 'text', 'The ID on the map.');
        $page->add_spacer($index);
        $page->add_form_group($index, 'City Planning Notes:', 'cityplanning_notes', 'textarea');
        $page->add_spacer($index);
        $page->add_form_group($index, 'Art Notes:', 'art_notes', 'textarea');
        $page->add_spacer($index);
    }
}

$page->printPage();

function camelize($value)
{
    return lcfirst(strtr(ucwords(strtr($value, array('_' => ' ', '.' => '_ ', '\\' => '_ '))), array(' ' => '')));
}
