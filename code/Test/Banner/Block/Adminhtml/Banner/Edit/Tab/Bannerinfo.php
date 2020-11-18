<?php

namespace Test\Banner\Block\Adminhtml\Banner\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Framework\Stdlib\DateTime;
use Test\Banner\Model\Banner;
use Test\Banner\Model\System\Config\Status;
use Test\Banner\Helper\Databanner;


class Bannerinfo extends Generic implements TabInterface
{
    /**
     * @var Config
     */
    protected $_wysiwygConfig;

    /**
     * @var Status
     */
    protected $_status;

    protected $_databanner;


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
        Databanner $databanner,

        array $data = []
    )
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_status = $status;
        $this->_databanner = $databanner;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        /* @var $model Banner */
        $model = $this->_coreRegistry->registry('banner_info');

        /** @var Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('banner_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Banner Information')]);

        if ($model->getId()) {
            $fieldset->addField('banner_id', 'hidden', ['name' => 'banner_id']);
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Banner Name'),
                'title' => __('Banner Name'),
                'required' => true,
            ]
        );


        $fieldset->addField(
            'image',
            'file',
            [
                'name' => 'image',
                'label' => __('Image'),
                'title' => __('Image'),
                'required' => false,
                'after_element_html' => $this->getImageHtml('image', $model->getBannerImage())
            ]
        );
        $fieldset->addField(
            'url',
            'text',
            [
                'name' => 'url',
                'label' => __('Url'),
                'title' => __('Url'),
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
                'label' => __(' Status'),
                'title' => __('Status'),
                'options' => $this->_status->toOptionArray(),
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
        return __('Banner Information');
    }

    /**
     * Prepare title for tab
     *
     * @return Phrase
     */
    public function getTabTitle()
    {
        return __('Banner Information');
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

    protected function getImageHtml($field, $image)
    {
        $html = '';
        if ($image) {
            $html .= '<p style="margin-top: 5px">';
            $html .= '<image style="min-width:300px;max-width:100%;" src="' . $this->_databanner->getImageUrl($image) . '" />';
            $html .= '<input type="hidden" value="' . $image . '" name="old_' . $field . '"/>';
            $html .= '</p>';
        }
        return $html;
    }
}
