<?php
class EmailHelperTest extends CITestCase
{    
    public function setUp()
    {
//        $this->CI->load->helper('email');
//        $this->CI->load->model('contactmodel');
    }

    public function testEmailValidation()
    {
        $this->assertTrue(1);
        $this->assertFalse(1);
    }

//    public function testContactsQty()
//    {
////        $qty = $this->CI->contactmodel->getContactsQty();
//        $this->assertEquals($qty, $this->db->getRowCount('contacts'));
//    }
}