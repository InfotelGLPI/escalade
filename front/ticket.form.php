<?php
/**
 * -------------------------------------------------------------------------
 * Escalade plugin for GLPI
 * -------------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of Escalade.
 *
 * Escalade is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Escalade is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Escalade. If not, see <http://www.gnu.org/licenses/>.
 * -------------------------------------------------------------------------
 * @copyright Copyright (C) 2015-2022 by Escalade plugin team.
 * @license   GPLv2 https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://github.com/pluginsGLPI/escalade
 * -------------------------------------------------------------------------
 */

use Glpi\Event;

include("../../../inc/includes.php");
Session::checkLoginUser();

$groupTicket = new Group_Ticket();
$ticketUser = new Ticket_User();

if (empty($_GET["id"])) {
    $_GET["id"] = "";
}
$tickets_id = $_POST["tickets_id"];

if (isset($_POST["add"])) {
    $checkbox = $_POST["escalation"];
    if (!empty($_POST["groups_id"]) && !empty($_POST["comment"]) && !empty($tickets_id)) {

        $input['tickets_id'] = $tickets_id;
        $input['groups_id'] = $_POST["groups_id"];
        $input['escalade_comment'] = $_POST["comment"];
        $input['type'] = CommonITILActor::ASSIGN;
        if ($_POST['is_observer_checkbox']) {

            $inputTicketUser['type'] = CommonITILActor::OBSERVER;
            $inputTicketUser['tickets_id'] = $tickets_id;
            $inputTicketUser['users_id'] = Session::getLoginUserID();
            $ticketUser->add($inputTicketUser);

        }
        $groupTicket->add($input);
    }
}

Html::back();
