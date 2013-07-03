    <?php defined('SYSPATH') OR die('No direct access allowed.');

    class Model_Post extends ORM{

    protected $_belongs_to = array('subcategory' => array(), 'user' => array());
    protected $_has_many = array('logs' => array());

    protected $_rules = array(
        'title' =>  array('not_empty' => NULL),
        'price' =>  array(
            'not_empty'  => NULL,
            'numeric'    => NULL
        ),
        'email' => array(
            'not_empty' => NULL,
            'email' => NULL
        ),
        'subcategory_id' => array(
            'not_empty' => NULL
        ),
        'description' =>  array(
            'not_empty' => NULL
        ));

        protected $_callbacks = array(
            'subcategory_id' => array('Model_Subcategory::valid_ids')
        );

    public function __construct()
    {
    	parent::__construct();
    }
} // End Post_Model