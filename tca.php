<?php

if (!defined('TYPO3_MODE'))
    die('Access denied.');

$TCA['tx_tagpack_tags'] = array(
    'ctrl' => $TCA['tx_tagpack_tags']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,tagtype,category,name,description,quodvide,relations'),
    'feInterface' => $TCA['tx_tagpack_tags']['feInterface'],
    'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
                )
            )
        ),
        'l18n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_tagpack_tags',
                'foreign_table_where' => 'AND tx_tagpack_tags.pid=###CURRENT_PID### AND tx_tagpack_tags.sys_language_uid IN (-1,0)',
            )
        ),
        'l18n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough'
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check',
                'default' => '0'
            )
        ),
        'starttime' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => '8',
                'max' => '20',
                'eval' => 'date',
                'default' => '0',
                'checkbox' => '0'
            )
        ),
        'endtime' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => '8',
                'max' => '20',
                'eval' => 'date',
                'checkbox' => '0',
                'default' => '0',
                'range' => array(
                    'upper' => mktime(0, 0, 0, 12, 31, 2020),
                    'lower' => mktime(0, 0, 0, date('m') - 1, date('d'), date('Y'))
                )
            )
        ),
        'fe_group' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
                ),
                'foreign_table' => 'fe_groups'
            )
        ),
        'tagtype' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tagpack/locallang_db.xml:tx_tagpack_tags.tagtype',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('LLL:EXT:tagpack/locallang_db.xml:tx_tagpack_tags.tagtype.1', 0),
                    array('LLL:EXT:tagpack/locallang_db.xml:tx_tagpack_tags.tagtype.2', 1),
                    array('LLL:EXT:tagpack/locallang_db.xml:tx_tagpack_tags.tagtype.3', 2),
                ),
            )
        ),
        'category' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tagpack/locallang_db.xml:tx_tagpack_tags.category',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_tagpack_categories'
            )
        ),
        'name' => Array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tagpack/locallang_db.xml:tx_tagpack_tags.name',
            'config' => Array(
                'type' => 'input',
                'size' => '30',
                'eval' => 'required',
            )
        ),
        'description' => Array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tagpack/locallang_db.xml:tx_tagpack_tags.description',
            'config' => Array(
                'type' => 'text',
                'cols' => '40',
                'rows' => '10',
            )
        ),
        'quodvide' => Array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tagpack/locallang_db.xml:tx_tagpack_tags.quodvide',
            'config' => Array(
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_tagpack_tags',
                'size' => 8,
                'minitems' => 0,
                'maxitems' => 999999999,
                'MM' => 'tx_tagpack_tags_quodvide_mm',
            )
        ),
        'relations' => Array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tagpack/locallang_db.xml:tx_tagpack_tags.relations',
            'config' => Array(
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => '*',
                'prepend_tname' => 1,
                'size' => 8,
                'minitems' => 0,
                'maxitems' => 999999999,
                'MM' => 'tx_tagpack_tags_relations_mm',
                'wizards' => array(
                    '_VALIGN' => 'top',
                    'edit' => array(
                        'type' => 'popup',
                        'title' => 'LLL:EXT:tagpack/locallang_db.xml:tx_tagpack_tags.edit',
                        'script' => 'wizard_edit.php',
                        'icon' => 'edit2.gif',
                        'popup_onlyOpenIfSelected' => 1,
                        'notNewRecords' => 1,
                        'JSopenParams' => 'height=500,width=800,status=0,menubar=0,scrollbars=1,resizable=yes'
                    ),
                ),
            ),
        ),
    ),
    'types' => array(
        '0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, tagtype, category, name, description, quodvide, relations')
    ),
    'palettes' => array(
        '1' => array('showitem' => 'starttime, endtime, fe_group')
    )
);

$TCA['tx_tagpack_categories'] = array(
    'ctrl' => $TCA['tx_tagpack_categories']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,name'),
    'feInterface' => $TCA['tx_tagpack_categories']['feInterface'],
    'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
                )
            )
        ),
        'l18n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_tagpack_tags',
                'foreign_table_where' => 'AND tx_tagpack_categories.pid=###CURRENT_PID### AND tx_tagpack_categories.sys_language_uid IN (-1,0)',
            )
        ),
        'l18n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough'
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check',
                'default' => '0'
            )
        ),
        'starttime' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => '8',
                'max' => '20',
                'eval' => 'date',
                'default' => '0',
                'checkbox' => '0'
            )
        ),
        'endtime' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => '8',
                'max' => '20',
                'eval' => 'date',
                'checkbox' => '0',
                'default' => '0',
                'range' => array(
                    'upper' => mktime(0, 0, 0, 12, 31, 2020),
                    'lower' => mktime(0, 0, 0, date('m') - 1, date('d'), date('Y'))
                )
            )
        ),
        'fe_group' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
                ),
                'foreign_table' => 'fe_groups'
            )
        ),
        'name' => Array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tagpack/locallang_db.xml:tx_tagpack_categories.name',
            'config' => Array(
                'type' => 'input',
                'size' => '30',
                'eval' => 'required,uniqueInPid',
            )
        ),
    ),
    'types' => array(
        '0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, name,')
    ),
    'palettes' => array(
        '1' => array('showitem' => 'starttime, endtime, fe_group')
    )
);
?>