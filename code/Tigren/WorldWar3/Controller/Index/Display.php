<?php
namespace Tigren\WorldWar3\Controller\Index;

use Magento\Framework\App\Action\Context;

class Display extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_postFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Tigren\WorldWar3\Model\PostFactory $postFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    public function create()
    {
        $data = [
            'name' => 'BF4',
            'url_key' => 'none',
            'post_content' => 'Operation Locker'
        ];
        $post = $this->_postFactory->create();
        $post->addData($data)->save();
    }

    public function update()
    {
        $data = [
            'name' => 'ACR',
            'url_key'=>'BF4/CARBINE/ACR',
            'post_content'=>'800RPM'
        ];
        $post = $this->_postFactory->create();
        $id = $post->load(3); // column ID
        foreach ($data as $key=>$value)
        {
            $id->setData($key,$value); // insert data from array
        }
        $post->save();
    }

    public function delete()
    {
        $post = $this->_postFactory->create();
        $post->load(2)->delete();
    }

    public function execute()
    {

        //$this->create();
        //$this->delete();
        $this->update();
        return $this->_pageFactory->create();
    }
}
