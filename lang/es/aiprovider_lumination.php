<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Spanish language strings for aiprovider_lumination.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['apikey'] = 'Clave de la API de AI Tutor';
$string['apikey_help'] = 'Tu clave de la API de AI Tutor (empieza por sk-tutor-). Regístrate en https://ai-tutor.ai y crea una clave en https://ai-tutor.ai/dashboard/api. Las cuentas nuevas reciben 20 $ en créditos gratuitos. El generador de cursos de Lumination AI y los demás complementos de Lumination también usan esta clave.';
$string['backtoproviders'] = 'Volver a los proveedores de IA';
$string['baseurl'] = 'URL base de la API';
$string['baseurl_help'] = 'La URL base de la API de AI Tutor, incluido /api/v1. Deja el valor por defecto salvo que Lumination AI te indique otra.';
$string['defaultinstancename'] = 'Lumination AI';
$string['error_emptyreply'] = 'La API de AI Tutor devolvió una respuesta vacía.';
$string['errorapiconnect'] = 'No se pudo conectar con la API de AI Tutor en {$a->host} ({$a->detail}). Revisa la URL base de la API en los ajustes del plugin y que este servidor tenga acceso a internet. ID de solicitud: {$a->requestid}';
$string['errorapicredits'] = 'Tu clave de la API de AI Tutor se ha quedado sin créditos (HTTP 402). Compra créditos en https://ai-tutor.ai/dashboard/api y vuelve a intentarlo. ID de solicitud: {$a->requestid}';
$string['errorapihttp'] = 'La API de AI Tutor en {$a->host} devolvió HTTP {$a->code}: {$a->detail}. ID de solicitud: {$a->requestid}';
$string['errorapijob'] = 'La API de AI Tutor no pudo completar la solicitud: {$a->detail}. ID de solicitud: {$a->requestid}';
$string['errorapikey'] = 'La API de AI Tutor en {$a->host} rechazó la clave de API (HTTP {$a->code}: {$a->detail}). Abre «Probar conexión» desde los ajustes del proveedor Lumination AI para ver qué clave está usando Moodle y compárala con la clave de https://ai-tutor.ai/dashboard/api. Comprueba también que la URL base de la API sea https://ai-tutor.ai/api/v1. ID de solicitud: {$a->requestid}';
$string['keyhint'] = '{$a->start}...{$a->end} ({$a->length} caracteres)';
$string['noinstance'] = 'No hay ningún proveedor Lumination AI activado. Crea uno en Administración del sitio > IA > Proveedores de IA, añade tu clave de API y actívalo.';
$string['pluginname'] = 'Proveedor Lumination AI';
$string['privacy:metadata:aitutor'] = 'La API de AI Tutor de Lumination AI procesa el texto que recibe para responder a la solicitud.';
$string['privacy:metadata:aitutor:prompttext'] = 'El texto que un usuario escribió o seleccionó, con la instrucción de Moodle para la acción.';
$string['testconnection'] = 'Probar conexión';
$string['testconnection_baseurl'] = 'URL base de la API en uso: {$a}';
$string['testconnection_key'] = 'Clave de API en uso: {$a}';
$string['testconnection_keyformat'] = 'La clave de API no empieza por sk-tutor-, así que probablemente sea una clave de la antigua API de Lumination. Crea una clave nueva en https://ai-tutor.ai/dashboard/api.';
$string['testconnection_keyincomplete'] = 'La clave de API no parece completa. Las claves de AI Tutor son sk-tutor- seguido de 48 letras y números. Si el panel muestra la clave acortada u oculta (con ... o puntos), crea una clave nueva y cópiala entera cuando se muestre.';
$string['testconnection_link'] = 'Probar la clave de API y la URL base';
$string['testconnection_notapi'] = 'El servidor en {$a->host} respondió con HTTP {$a->code}, pero no parece la API de AI Tutor ({$a->detail}). Revisa la URL base de la API; debería ser https://ai-tutor.ai/api/v1. ID de solicitud: {$a->requestid}';
$string['testconnection_ok'] = 'Conectado a {$a->host}. La clave de API ha sido aceptada.';
