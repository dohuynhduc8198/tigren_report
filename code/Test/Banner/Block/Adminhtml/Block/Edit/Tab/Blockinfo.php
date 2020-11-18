<?php

namespace Test\Banner\Block\Adminhtml\Block\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Framework\Stdlib\DateTime;
use Test\Banner\Model\Block;
use Test\Banner\Model\System\Config\Status;
use Test\Banner\Helper\Datablock;


class Blockinfo extends Generic implements TabInterface
{
    /**
     * @var Config
     */
    protected $_wysiwygConfig;

    /**
     * @var Status
     */
    protected $_status;
    protected $_position;

    /**
     * @var Datablock $blockHelper
     */
    protected $_blockHelper;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param Status $status
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Status $status,
        Datablock $blockHelper,
        array $data = []
    )
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_blockHelper = $blockHelper;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        /* @var $model Block */
        $model = $this->_coreRegistry->registry('block_info');

        /** @var Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Block Information')]);

        if ($model->getId()) {
            $fieldset->addField('block_id', 'hidden', ['name' => 'block_id']);
        }

        $fieldset->addField(
            'block_name',
            'text',
            [
                'name' => 'block_name',
                'label' => __('Block Name'),
                'title' => __('Block Name'),
                'required' => true,
            ]
        );


        $fieldset->addField(
            'position',
            'select',
            [
                'name' => 'position',
                'label' => __('Block position'),
                'title' => __('Block Position'),
                'values' => $this->_blockHelper->getPositionOptions(),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'display_type',
            'select',
            [
                'name' => 'display_type',
                'label' => __('Display Type'),
                'title' => __('Display Type'),
                'values' => $this->_blockHelper->getDisplayTypeOptions(),
                'required' => true,
            ]
        );
        $fieldset->addField('from', 'date', array(
                'name' => 'from',
                'label' => __('From date'),
                'title' => __('From date'),
                'date_format' => DateTime::DATE_INTERNAL_FORMAT,
                'time_format' => 'HH:mm:ss',
                'required' => false,
            )
        );

        $fieldset->addField('to', 'date', array(
                'name' => 'to',
                'label' => __('To date'),
                'title' => __('To date'),
                'date_format' => DateTime::DATE_INTERNAL_FORMAT,
                'time_format' => 'HH:mm:ss',
                'required' => false,
            )
        );

        $fieldset->addField(
            'sort',
            'text',
            array(
                'name' => 'sort',
                'label' => __('Sort Order'),
                'title' => __('Sort Order'),
                'required' => false,
                'class' => 'validate-number'
            )
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'title' => __('Status'),
                'options' => ['1' => __('Enable'), '0' => __('Disable')],
                'required' => true,
            ]
        );
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();


    }

    /**
     * Prepare label for tab
     *
     * @return Phrase
     */
    public function getTabLabel()
    {
        return __('Block Information');
    }

    /**
     * Prepare title for tab
     *
     * @return Phrase
     */
    public function getTabTitle()
    {
        return __('Block Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
