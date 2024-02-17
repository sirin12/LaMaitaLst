<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CustomAuth {

    var $CI;

    function __construct() {

        $this->CI = & get_instance();

        $this->CI->load->database();

        $this->CI->load->helper('url');
    }

    function check_access($access, $default_redirect = false, $redirect = false) {

        $user = $this->CI->session->userdata('user');

        $this->CI->db->select('*');

        $this->CI->db->where('id', $user['id']);

        $this->CI->db->limit(1);

        $result = $this->CI->db->get('clients');

        $result = $result->row();



        //result should be an object I was getting odd errors in relation to the object.
        //if $result is an array then the problem is present.

        if (!$result || is_array($result)) {

            $this->logout();

            return false;
        }

        //  echo $result->access;

        if ($access) {

            if ($access == $result->access) {

                return true;
            } else {

                if ($redirect) {

                    redirect($redirect);
                } elseif ($default_redirect) {

                    redirect(config_item('user_folder') . '/espace_client/');
                } else {

                    return false;
                }
            }
        }
    }

    /*

      this checks to see if the user is logged in

      we can provide a link to redirect to, and for the login page, we have $default_redirect,

      this way we can check if they are already logged in, but we won't get stuck in an infinite loop if it returns false.

     */

    function is_logged_in($redirect=false, $default_redirect = true) {




        $user = $this->CI->session->userdata('user');



        if (!$user) {

            //check the cookie

            if (isset($_COOKIE['gremdauser'])) {

                //the cookie is there, lets log the customer back in.

                $info = $this->aes256Decrypt(base64_decode($_COOKIE['gremdauser']));

                $cred = json_decode($info, true);



                if (is_array($cred)) {

                    if ($this->login_user($cred['email'], $cred['password'])) {

                        return $this->is_logged_in($redirect, $default_redirect);
                    }
                }
            }



            if ($redirect) {

                $this->CI->session->set_flashdata('redirect', $redirect);
            }else{
				 $this->CI->session->set_flashdata('redirect', uri_string());
			}



            if ($default_redirect) {

                redirect('#login');
            }



            return false;
        } else {

            return true;
        }
    }
	
	function is_logged_in_espace($redirect=false, $default_redirect = true, $espace) {
        $user = $this->CI->session->userdata('user');

        if (!$user) {

            //check the cookie

            if (isset($_COOKIE['gremdauser'])) {

                //the cookie is there, lets log the customer back in.

                $info = $this->aes256Decrypt(base64_decode($_COOKIE['gremdauser']));

                $cred = json_decode($info, true);



                if (is_array($cred)) {

                    if ($this->login_user($cred['email'], $cred['password'],$espace)) {

                        return $this->is_logged_in_espace($redirect, $default_redirect,$espace);
                    }
                }
            }



            if ($redirect) {

                $this->CI->session->set_flashdata('redirect', $redirect);
            }else{
				 $this->CI->session->set_flashdata('redirect', uri_string());
			}



            if ($default_redirect) {

                redirect('#login');
            }



            return false;
        } else {

            return true;
        }
    }
	
    /*

      this function return the connected user.

     */

    function get_connected() {
        $user = $this->CI->session->userdata('user');

        return($user);
    }


    function login_user($identity, $password, $remember = false) {

        // make sure the email doesn't go into the query as false or 0

        if (!$identity) {

            return false;
        }

        $this->CI->db->select('clients.*');
        $this->CI->db->where('email', $identity);
        $this->CI->db->where('passwordMD5', md5('ArtOf!*'.$password));

        $this->CI->db->limit(1);

        $result = $this->CI->db->get('clients');

        $result = $result->row_array();



        if (sizeof($result) > 0) {

            $user['user'] = $result;

			if($result['status']>0)
			{
				if ($remember) {

					$loginCred = json_encode(array('email' => $identity, 'passwordMD5' => md5('ArtOf!*'.$password)
));

					$loginCred = base64_encode($this->aes256Encrypt($loginCred));

					//remember the user for 6 months

					$this->generateCookie($loginCred, strtotime('+6 months'));
				}

				$this->CI->session->set_userdata($user);
			}
            return $result;
        } else {

            return false;
        }
    }
	
	function login_espace($identity, $password,$espace, $remember = false) {

        // make sure the email doesn't go into the query as false or 0

        if (!$identity) {

            return false;
        }

        $this->CI->db->select('clients.*');
        $this->CI->db->where('email', $identity);
        $this->CI->db->where('passwordMD5', md5('ArtOf!*'.$password));
		$this->CI->db->where('espace_pro', $espace);

        $this->CI->db->limit(1);

        $result = $this->CI->db->get('clients');

        $result = $result->row_array();



        if (sizeof($result) > 0) {

            $user['user'] = $result;

			if($result['status']>0)
			{
				if ($remember) {

					$loginCred = json_encode(array('email' => $identity, 'passwordMD5' => md5('ArtOf!*'.$password)));

					$loginCred = base64_encode($this->aes256Encrypt($loginCred));

					//remember the user for 6 months

					$this->generateCookie($loginCred, strtotime('+6 months'));
				}

				$this->CI->session->set_userdata($user);
			}
            return $result;
        } else {

            return false;
        }
    }
	

    private function generateCookie($data, $expire) {

        setcookie('gremdauser', $data, $expire, '/', $_SERVER['HTTP_HOST']);
    }

    private function aes256Encrypt($data) {

        $key = config_item('encryption_key');

        if (32 !== strlen($key)) {

            $key = hash('SHA256', $key, true);
        }

        $padding = 16 - (strlen($data) % 16);

        $data .= str_repeat(chr($padding), $padding);

        return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16));
    }

    private function aes256Decrypt($data) {

        $key = config_item('encryption_key');

        if (32 !== strlen($key)) {

            $key = hash('SHA256', $key, true);
        }

        $data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16));

        $padding = ord($data[strlen($data) - 1]);

        return substr($data, 0, -$padding);
    }

    /*

      this function does the logging out

     */

    function logout() {

        $this->CI->session->unset_userdata('user');

        //force expire the cookie

        $this->generateCookie('', time() - 3600);
    }

    /*

      This function resets the clients password and cins them a copy

     */

    function reset_password($email) {

        $user = $this->get_user_by_email($email);

        if ($user) {

            $this->CI->load->helper('string');

            $this->CI->load->library('email');

            $new_password = random_string('alnum', 8);

            $user['password'] = $new_password;

            $this->save_user($user);

            $this->CI->email->from(config_item('email'), config_item('site_name'));

            $this->CI->email->to($user['email']);

            $this->CI->email->subject(config_item('site_name') . ': user Password Reset');

            $this->CI->email->message('Your password has been reset to ' . $new_password . '.');

            $this->CI->email->send();

            return true;
        } else {

            return false;
        }
    }

    /*

      This function gets the user by their email address and returns the values in an array

      it is not intended to be called outside this class

     */

    private function get_user_by_email($email) {

        $this->CI->db->select('*');

        $this->CI->db->where('email', $email);

        $this->CI->db->limit(1);

        $result = $this->CI->db->get('clients');

        $result = $result->row_array();



        if (sizeof($result) > 0) {

            return $result;
        } else {

            return false;
        }
    }

    /*

      This function takes user array and inserts/updates it to the database

     */

    function save($user) {

        if ($user['id']) {

            $this->CI->db->where('id', $user['id']);

            $this->CI->db->update('user', $user);
        } else {

            $this->CI->db->insert('user', $user);
        }
    }

    /*

      This function gets a complete list of all user

     */

    function get_user_list() {

        $this->CI->db->select('*');

        $this->CI->db->order_by('raison', 'ASC');

        $this->CI->db->order_by('email', 'ASC');

        $result = $this->CI->db->get('clients');

        $result = $result->result();



        return $result;
    }

    /*

      This function gets an individual user

     */

    function get_user($id) {

        $this->CI->db->select('*');

        $this->CI->db->where('id', $id);

        $result = $this->CI->db->get('clients');

        $result = $result->row();



        return $result;
    }


}
