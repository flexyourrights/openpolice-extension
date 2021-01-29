<?php
/**
  * OpenPoliceExtension the core top-level class for which extends
  * and can override many functions specific to OpenPolice.org.
  *
  * OpenPolice.org
  * @package  flexyourrights/openpolice-extension
  * @author  Morgan Lesko <rockhoppers@runbox.com>
  * @since  v0.3.0
  */
namespace FlexYourRights\OpenPoliceExtension\Controllers;

use FlexYourRights\OpenPolice\Controllers\OpenPolice;

class OpenPoliceExtension extends OpenPolice
{
    /**
     * Overrides primary OpenPolice.org printing of individual nodes from 
     * surveys and site pages. This is one of the main routing hubs
     * for OpenPoliceExtension customizations beyond Survloop defaults.
     * This overrides the printNodePublicDefault function in
     * RockHopSoft\Survloop\Tree\TreeSurvForm.
     *
     * @param  TreeNodeSurv $curr
     * @return string
     */
    protected function extensionNodePrint(&$curr = null)
    {
        if ($curr->nID == 0) { // Survey/page branching tree node ID
            return 'Custom node output';
        }
        return '';
    }

    /**
     * Overrides default OpenPolice.org & Survloop behavior
     * for responses to multiple-choice questions.
     * Return $curr (instead of null) to override.
     * This overrides the printNodePublicElements function in
     * RockHopSoft\Survloop\Tree\TreeSurvForm.
     *
     * @param  SLNode &$curr
     * @return SLNode
     */
    protected function extensionResponses(&$curr)
    {
        return null;
    }

    /**
     * Delegate the custom overrides for Survloop default 
     * methods to retrieve current session data required
     * by the current node.
     * This overrides the printNodePublicCurrData function in
     * RockHopSoft\Survloop\Tree\TreeSurvFormPrintLoad.
     * e.g. flexyourrights/openpolice-extension
     *
     * @param  TreeNodeSurv $curr
     * @return array
     */
    protected function extensionPrintNodeSessData(&$curr)
    {
        return [];
    }

    /**
     * Override default behavior for submitting survey forms,
     * delegateing specifc saving procedures for custom nodes.
     * This overrides the postNodePublic function in
     * RockHopSoft\Survloop\Tree\TreeSurvInput.
     *
     * @param  TreeNodeSurv $curr
     * @return boolean
     */
    protected function extensionPostNodePublic(&$curr)
    {
        return false; // false to continue standard post processing
    }

    /**
     * Overrides OpenPolice.org & Survloop printing of individual nodes from 
     * surveys and site pages. This is one of the main routing hubs
     * for OpenPolice.org customizations beyond Survloop defaults.
     * Return null to leave defaults alone. Otherwise, return 
     * report detail array used by nodePrintVertProgress 
     * in RockHopSoft\Survloop\Tree\TreeSurvDataPrint.
     *
     * @param  TreeNodeSurv $curr
     * @param  string $var
     * @return array
     */
    protected function extensionNodePrintVertProgress(&$curr = null, $val = null)
    {
        return null;
    }

    /**
     * Overrides or disables the default Survloop & OpenPolice.org 
     * printing of survey Back/Next buttons.
     * This overrides the nodePrintButton function in
     * RockHopSoft\Survloop\Tree\TreeSurvFormUtils.
     *
     * @param  int $nID
     * @param  string $promptNotes
     * @return string
     */
    protected function extensionNodePrintButton($nID = -3, $promptNotes = '')
    { 
        return '';
    }

    /**
     * Delegate the conditional checks which are customized from
     * the simpler default OpenPolice.org & Survloop existing thus far.
     * This overrides the parseConditions function in
     * RockHopSoft\Survloop\Tree\TreeSurvConds.
     * Return 0 or 1 (instead of -1) to override.
     *
     * @param  int $nID
     * @param  string $condition
     * @return int
     */
    protected function extensionCheckNodeConditions($nID, $condition = '')
    {
        return -1;
    }

    /**
     * Check for ajax requests customized beyond 
     * Survloop's default behavior, called via /ajax/{type}.
     * This overrides the ajaxChecks function in
     * RockHopSoft\Survloop\Tree\TreeSurv.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  string $type
     * @return boolean
     */
    protected function extensionAjaxChecks(Request $request, $type = '')
    {
        return '';
    }
    
    
}