<?php
namespace App\Helpers;

use App\Helpers\Contracts\HelperContract; 
use Crypt;
use Carbon\Carbon; 
use Mail;
use Auth;
use \Swift_Mailer;
use \Swift_SmtpTransport;
use App\Models\User;
use App\Models\Carts;
use App\Models\ShippingDetails;
use App\Models\Products;
use App\Models\ProductData;
use App\Models\ProductImages;
use App\Models\Categories;
use App\Models\Discounts;
use App\Models\Reviews;
use App\Models\Banners;
use App\Models\Trackings;
use App\Models\AnonOrders;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Ads;
use App\Models\Settings;
use App\Models\Plugins;
use App\Models\Couriers;
use App\Models\Senders;
use App\Models\Catalogs;
use App\Models\OrderReviews;
use Analytics;
use Spatie\Analytics\Period;
use Cloudinary\Cloudinary;
use \Cloudinary\Api;
use \Cloudinary\Api\Response;
use \Cloudinary\Api\Upload\UploadApi;
use GuzzleHttp\Client;
use Image;

class Helper implements HelperContract
{    

            public $emailConfig = [
                           'ss' => 'smtp.gmail.com',
                           'se' => 'uwantbrendacolson@gmail.com',
                           'sp' => '587',
                           'su' => 'uwantbrendacolson@gmail.com',
                           'spp' => 'kudayisi',
                           'sa' => 'yes',
                           'sec' => 'tls'
                       ];    

			public $deliveryStatuses = [
                           'pickup' => 'Your order has been processed and is scheduled for pickup.',
                           'transit' => 'The package has left the pickup point and is on its way to the delivery address.',
                           'delivered' => 'The package has been delivered to the receiver.',
                           'return' => 'The delivery address was not correct and the package has been returned.',
                           'receiver_not_present' => 'The receiver was not present at the delivery address and the package has been returned.'
                       ];     
                        
             public $signals = ['okays'=> ["login-status" => "Sign in successful",            
                     "signup-status" => "Account created successfully! You can now login to complete your profile.",
                     "create-product-status" => "Product added!",
                     "create-category-status" => "Category added!",
                     "update-product-status" => "Product updated!",
                     "delete-product-status" => "Product deleted!",
                     "edit-category-status" => "Category updated!",
                     "update-status" => "Account updated!",
                     "update-user-status" => "User account updated!",
                     "config-status" => "Config added/updated!",
                     "create-ad-status" => "Ad added!",
                     "edi-ad-status" => "Ad updated!",
					 "create-banner-status" => "Banner added!",
                     "edit-banner-status" => "Banner updated!",
                     "edit-review-status" => "Review info updated!",
                     "edit-order-status" => "Order info updated!",
                     "contact-status" => "Message sent! Our customer service representatives will get back to you shortly.",
                     "create-tracking-status" => "Tracking info updated.",
                     "update-discount-status" => "Discount updated.",
                     "create-discount-status" => "Discount created.",
                     "delete-discount-status" => "Discount deleted.",
                     "no-sku-status" => "Please select a product for single discount.",
                     "no-category-status" => "Please select a category for category discount.",
                     "set-cover-image-status" => "Product image updated",
                     "delete-image-status" => "Image deleted",
                     "delete-order-status" => "Order deleted",
                     "bulk-update-tracking-status" => "Trackings updated",
                     "bulk-confirm-payment-status" => "Payments confirmed",
                     "bulk-update-products-status" => "Products updated",
                     "bulk-upload-products-status" => "Products uploaded",
                     "no-validation-status" => "Please fill all required fields",
                     "add-plugin-status" => "Plugin added",
                     "update-plugin-status" => "Plugin updated",
                     "remove-plugin-status" => "Plugin removed",
                     "add-sender-status" => "Sender added",
                     "remove-sender-status" => "Sender removed",
                     "mark-sender-status" => "Sender updated",
					 "add-catalog-status" => "Item(s) added to catalog",
                     "remove-catalog-status" => "Item(s) removed from catalog",
                     "update-catalog-status" => "Catalog updated",
					 "add-courier-status" => "Courier added",
                     "remove-courier-status" => "Courier removed",
                     "update-courier-status" => "Courier info updated",
		     "ask-review-status" => "Review request sent",
		     "ask-review-email-status" => "No customer email on record.",
                     ],
                     'errors'=> ["login-status-error" => "There was a problem signing in, please contact support.",
					 "signup-status-error" => "There was a problem signing in, please contact support.",
					 "update-status-error" => "There was a problem updating the account, please contact support.",
					 "update-user-status-error" => "There was a problem updating the user account, please contact support.",
					 "contact-status-error" => "There was a problem sending your message, please contact support.",
					 "create-product-status-error" => "There was a problem adding the product, please try again.",
					 "create-category-status-error" => "There was a problem adding the category, please try again.",
					 "update-product-status-error" => "There was a problem updating product info, please try again.",
					 "edit-category-status-error" => "There was a problem updating category, please try again.",
					 "create-ad-status-error" => "There was a problem adding new ad, please try again.",
					 "edit-ad-status-error" => "There was a problem updating the ad, please try again.",
					 "create-banner-status-error" => "There was a problem adding new banner, please try again.",
					 "edit-banner-status-error" => "There was a problem updating the banner, please try again.",
					 "edit-order-status-error" => "There was a problem updating the order, please try again.",
					 "create-tracking-status-error" => "There was a problem updating tracking information, please try again.",
					 "create-discount-status-error" => "There was a problem creating the discount, please try again.",
					 "update-discount-status-error" => "There was a problem updating the discount, please try again.",
					 "delete-image-status-error" => "There was a problem deleting the image, please try again.",
					 "set-cover-image-status-error" => "There was a problem updating the product image, please try again.",
					 "delete-discount-status-error" => "There was a problem deleting the discount, please try again.",
					"bulk-update-tracking-status-error" => "There was a problem updating trackings, please try again.",
					"bulk-confirm-payment-status-error" => "There was a problem confirming payments, please try again.",
					"bulk-update-products-status-error" => "There was a problem updating products, please try again.",
					"bulk-upload-products-status-error" => "There was a problem uploading products, please try again.",
					"add-courier-status-error" => "There was a problem adding the courier, please try again.",
                     "remove-courier-status-error" => "There was a problem removing the courier, please try again.",
                     "update-courier-status-error" => "There was a problem updating the courier, please try again.",
		     "ask-review-status-error" => "There was a problem asking for a review, please try again.",
		     
                    ]
                   ];
				   
		    public $categories = ['watches' => "Watches",
			                      'anklets' => "Anklets",
								  'bracelets' => "Bracelets",
								  'brooches' => "Brooches",
								  'earrings' => "Ear Rings",
								  'necklaces' => "Necklaces",
								  'rings' => "Rings"
								  ];
				   
	public $smtp = [
       'ss' => "smtp.gmail.com",
       'sp' => "587",
       'sec' => "tls",
       'sa' => "yes",
       'su' => "aceluxurystoree@gmail.com",
       'spp' => "Ace12345$",
       'sn' => "Ace Luxury Store",
       'se' => "aceluxurystoree@gmail.com"
  ];
  
  public $smtpp = [
       'gmail' => [
       'ss' => "smtp.gmail.com",
       'sp' => "587",
       'sec' => "tls",
       ],
       'yahoo' => [
       'ss' => "smtp.mail.yahoo.com",
       'sp' => "587",
       'sec' => "ssl",
       ],
  ];
  
   public $banks = [
      'access' => "Access Bank", 
      'citibank' => "Citibank", 
      'diamond-access' => "Diamond-Access Bank", 
      'ecobank' => "Ecobank", 
      'fidelity' => "Fidelity Bank", 
      'fbn' => "First Bank", 
      'fcmb' => "FCMB", 
      'globus' => "Globus Bank", 
      'gtb' => "GTBank", 
      'heritage' => "Heritage Bank", 
      'jaiz' => "Jaiz Bank", 
      'keystone' => "KeyStone Bank", 
      'polaris' => "Polaris Bank", 
      'providus' => "Providus Bank", 
      'stanbic' => "Stanbic IBTC Bank", 
      'standard-chartered' => "Standard Chartered Bank", 
      'sterling' => "Sterling Bank", 
      'suntrust' => "SunTrust Bank", 
      'titan-trust' => "Titan Trust Bank", 
      'union' => "Union Bank", 
      'uba' => "UBA", 
      'unity' => "Unity Bank", 
      'wema' => "Wema Bank", 
      'zenith' => "Zenith Bank"
 ];		

 public $states = [
			                       'abia' => 'Abia',
			                       'adamawa' => 'Adamawa',
			                       'akwa-ibom' => 'Akwa Ibom',
			                       'anambra' => 'Anambra',
			                       'bauchi' => 'Bauchi',
			                       'bayelsa' => 'Bayelsa',
			                       'benue' => 'Benue',
			                       'borno' => 'Borno',
			                       'cross-river' => 'Cross River',
			                       'delta' => 'Delta',
			                       'ebonyi' => 'Ebonyi',
			                       'enugu' => 'Enugu',
			                       'edo' => 'Edo',
			                       'ekiti' => 'Ekiti',
			                       'gombe' => 'Gombe',
			                       'imo' => 'Imo',
			                       'jigawa' => 'Jigawa',
			                       'kaduna' => 'Kaduna',
			                       'kano' => 'Kano',
			                       'katsina' => 'Katsina',
			                       'kebbi' => 'Kebbi',
			                       'kogi' => 'Kogi',
			                       'kwara' => 'Kwara',
			                       'lagos' => 'Lagos',
			                       'nasarawa' => 'Nasarawa',
			                       'niger' => 'Niger',
			                       'ogun' => 'Ogun',
			                       'ondo' => 'Ondo',
			                       'osun' => 'Osun',
			                       'oyo' => 'Oyo',
			                       'plateau' => 'Plateau',
			                       'rivers' => 'Rivers',
			                       'sokoto' => 'Sokoto',
			                       'taraba' => 'Taraba',
			                       'yobe' => 'Yobe',
			                       'zamfara' => 'Zamfara',
			                       'fct' => 'FCT'  
			];  
 
  
  
  //public $adminEmail = "tkudayisi@aceluxurystore.com";
  //public $suEmail = "aquarius4tkud@yahoo.com";
  
  public $adminEmail = "support@aceluxurystore.com";
  public $suEmail = "aceluxurystore@yahoo.com";
  
  public $googleProductCategories = [
				              'bracelets' => "191",
							  'brooches' => "197",
							  'earrings' => "194",
							  'necklaces' => "196",
							  'rings' => "200",
							  'anklets' => "189",
							  'scarfs' => "177",
							  'Hair Accessories' => "171"
							  ];
	

         #{'msg':msg,'em':em,'subject':subject,'link':link,'sn':senderName,'se':senderEmail,'ss':SMTPServer,'sp':SMTPPort,'su':SMTPUser,'spp':SMTPPass,'sa':SMTPAuth};
         function sendEmailSMTP($data,$view,$type="view")
           {
           	    // Setup a new SmtpTransport instance for new SMTP
                $transport = "";
if($data['sec'] != "none") $transport = new Swift_SmtpTransport($data['ss'], $data['sp'], $data['sec']);

else $transport = new Swift_SmtpTransport($data['ss'], $data['sp']);

   if($data['sa'] != "no"){
                  $transport->setUsername($data['su']);
                  $transport->setPassword($data['spp']);
     }
// Assign a new SmtpTransport to SwiftMailer
$smtp = new Swift_Mailer($transport);

// Assign it to the Laravel Mailer
Mail::setSwiftMailer($smtp);

$se = $data['se'];
$sn = $data['sn'];
$to = $data['em'];
$subject = $data['subject'];
                   if($type == "view")
                   {
                     Mail::send($view,$data,function($message) use($to,$subject,$se,$sn){
                           $message->from($se,$sn);
                           $message->to($to);
                           $message->subject($subject);
                          if(isset($data["has_attachments"]) && $data["has_attachments"] == "yes")
                          {
                          	foreach($data["attachments"] as $a) $message->attach($a);
                          } 
						  $message->getSwiftMessage()
						  ->getHeaders()
						  ->addTextHeader('x-mailgun-native-send', 'true');
                     });
                   }

                   elseif($type == "raw")
                   {
                     Mail::raw($view,$data,function($message) use($to,$subject,$se,$sn){
                            $message->from($se,$sn);
                           $message->to($to);
                           $message->subject($subject);
                           if(isset($data["has_attachments"]) && $data["has_attachments"] == "yes")
                          {
                          	foreach($data["attachments"] as $a) $message->attach($a);
                          } 
                     });
                   }
           }    

           function createUser($data)
           {
           	$ret = User::create([
                                                      'email' => $data['email'], 
                                                      'phone' => $data['phone'], 
                                                      'fname' => $data['fname'], 
                                                      'lname' => $data['lname'], 
                                                      'role' => $data['role'], 
                                                      'status' => "enabled", 
                                                      'verified' => "yes", 
                                                      'password' => bcrypt($data['pass']), 
                                                      ]);
                                                      
                return $ret;
           }
           
           function getShippingDetails($user)
           {
           	$ret = [];
			$uid = isset($user->id) ? $user->id: $user;
               $sdd = ShippingDetails::where('user_id',$uid)->get();
 
              if($sdd != null)
               {
				   foreach($sdd as $sd)
				   {
				      $temp = [];
                   	   $temp['company'] = $sd->company; 
                       $temp['address'] = $sd->address; 
                       $temp['city'] = $sd->city;
                       $temp['state'] = $sd->state; 
                       $temp['zipcode'] = $sd->zipcode; 
                       $temp['id'] = $sd->id; 
                       $temp['date'] = $sd->created_at->format("jS F, Y"); 
                       array_push($ret,$temp); 
				   }
               }                         
                                                      
                return $ret;
           }

		   
		   function bomb($data) 
           {
             $url = $data['url'];
               
			       $client = new Client([
                 // Base URI is used with relative requests
                 'base_uri' => 'https://mail.aceluxurystore.com',
                 // You can set any number of default request options.
                 //'timeout'  => 2.0,
				 'headers' => isset($data['headers']) && count($data['headers']) > 0 ? $data['headers'] : []
                 ]);
                  
				 
				 $dt = [
				    
				 ];
				 
				 if(isset($data['auth']))
				 {
					 $dt['auth'] = $data['auth'];
				 }
				 if(isset($data['data']))
				 {
					if(isset($data['type']) && $data['type'] == "raw")
					{
					  $dt['body'] = $data['data'];
					}
					else
					{
					  $dt['multipart'] = [];
					  foreach($data['data'] as $k => $v)
				      {
					    $temp = [
					      'name' => $k,
						  'contents' => $v
					     ];
						 
					     array_push($dt['multipart'],$temp);
				      }
					  
					   if(isset($data['atts']))
					   {
						   foreach($data['atts'] as $a)
						   {
							   $n = $a['name']; $r = $a['content']; 
							   $temp = [
					              'name' => 'attachment',
								  'filename' => $n,
						          'contents' => Psr7\Utils::tryFopen($r, 'r')
					           ];
						 
					           array_push($dt['multipart'],$temp);
						   }
					   }
					}
				   
				 }

				 
				 try
				 {
					# dd($dt);
					$res = $client->request(strtoupper($data['method']),$url,$dt);
					$ret = $res->getBody()->getContents(); 
			       //dd($ret);

				 }
				 catch(RequestException $e)
				 {
					dd($e);
					# $mm = (is_null($e->getResponse())) ? null: Psr7\str($e->getResponse());
					 $mm = (is_null($e->getResponse())) ? null: $e->getResponse();
					 $ret = json_encode(["status" => "error","message" => $mm]);
				 }
			     $rett = json_decode($ret);
           return $ret; 
           }
		   
		   function getUsers($all=false)
           {
           	$ret = [];
              $users = User::where('id','>',"0")->get();
             
              if($users != null)
               {
				  foreach($users as $u)
				  {
					  $uu = $this->getUser($u->id,$all);
					  array_push($ret,$uu);
				  }
               }                         
                                                      
                return $ret;
           }
		   
		   function getUser($id,$all=false)
           {
           	$ret = [];
               $u = User::where('email',$id)
			            ->orWhere('id',$id)->first();
 
              if($u != null)
               {
                   	$temp['fname'] = $u->fname; 
                       $temp['lname'] = $u->lname; 
                       //$temp['wallet'] = $this->getWallet($u);
                       $temp['phone'] = $u->phone; 
                       $temp['email'] = $u->email; 
                       $temp['role'] = $u->role;
                       if($all)
					   {
						   $sd =  $this->getShippingDetails($u);
						   $temp['sd'] = count($sd) > 0 ? $sd[0] : $sd;
					   }					   
                       $temp['status'] = $u->status; 
                       $temp['verified'] = $u->verified; 
                       $temp['id'] = $u->id; 
                       $temp['date'] = $u->created_at->format("jS F, Y h:i"); 
                       $ret = $temp; 
               }                          
                                                      
                return $ret;
           }
		   
		   
		    function getCarts()
           {
           	$ret = [];

			  $carts = Carts::where('id','>',"0")->get();
			  #dd($uu);
              if($carts != null)
               {
               	foreach($carts as $c) 
                    {
                    	$temp = [];
               	     $temp['id'] = $c->id; 
               	     $temp['user_id'] = $c->user_id; 
                        $temp['product'] = $this->getProduct($c->sku); 
                        $temp['qty'] = $c->qty; 
                        $temp['date'] = $c->created_at->format("jS F,Y h:i A"); 
                        array_push($ret, $temp); 
                   }
               }                                 
              			  
                return $ret;
           }
		   
		   
		   function getProducts()
           {
           	$ret = [];
              $products = Products::where('id','>',"0")->get();
              $products = $products->sortByDesc('created_at');
			  
              if($products != null)
               {
				  foreach($products as $p)
				  {
					  $pp = $this->getProduct($p->id);
					  array_push($ret,$pp);
				  }
               }                         
                                                      
                return $ret;
           }
		   
		   function getProduct($id,$imgId=false)
           {
           	$ret = [];
              $product = Products::where('id',$id)
			                 ->orWhere('sku',$id)->first();
       
              if($product != null)
               {
				  $temp = [];
				  $temp['id'] = $product->id;
				  $temp['name'] = $product->name;
				  $temp['sku'] = $product->sku;
				  $temp['qty'] = $product->qty;
				  $temp['in_catalog'] = $product->in_catalog;
				  $temp['status'] = $product->status;
				  $temp['pd'] = $this->getProductData($product->sku);
				  $temp['discounts'] = $this->getDiscounts($product->sku);
				  $imgs = $this->getImages($product->sku);
				  if($imgId) $temp['imgs'] = $imgs;
				  $temp['imggs'] = $this->getCloudinaryImages($imgs);
				  $ret = $temp;
               }                         
                                                      
                return $ret;
           }

		   function getProductData($sku)
           {
           	$ret = [];
              $pd = ProductData::where('sku',$sku)->first();
 
              if($pd != null)
               {
				  $temp = [];
				  $temp['id'] = $pd->id;
				  $temp['sku'] = $pd->sku;
				  $temp['amount'] = $pd->amount;
				  $temp['description'] = $pd->description;
				  $temp['in_stock'] = $pd->in_stock;
				  $temp['category'] = $pd->category;
				
				  $ret = $temp;
               }                         
                                                      
                return $ret;
           }
		   
		   function getProductImages($sku)
           {
           	$ret = [];
              $pis = ProductImages::where('sku',$sku)->get();
 
            
              if($pis != null)
               {
				  foreach($pis as $pi)
				  {
				    $temp = [];
				    $temp['id'] = $pi->id;
				    $temp['sku'] = $pi->sku;
				    $temp['cover'] = $pi->cover;
				    $temp['url'] = $pi->url;
				    array_push($ret,$temp);
				  }
               }                         
                                                      
                return $ret;
           }
		   
		   function isCoverImage($img)
		   {
			   return $img['cover'] == "yes";
		   }
		   
		   function getImage($pi)
           {
       	         $temp = [];
				 $temp['id'] = $pi->id;
				 $temp['sku'] = $pi->sku;
			     $temp['cover'] = $pi->cover;
				 $temp['url'] = $pi->url;
				 
                return $temp;
           }
		   
		   function getImages($sku)
		   {
			   $ret = [];
			   $records = $this->getProductImages($sku);
			   
			   $coverImage = ProductImages::where('sku',$sku)
			                              ->where('cover',"yes")->first();
										  
               $otherImages = ProductImages::where('sku',$sku)
			                              ->where('cover',"!=","yes")->get();
			  
               if($coverImage != null)
			   {
				   $temp = $this->getImage($coverImage);
				   array_push($ret,$temp);
			   }

               if($otherImages != null)
			   {
				   foreach($otherImages as $oi)
				   {
					   $temp = $this->getImage($oi);
				       array_push($ret,$temp);
				   }
			   }
			   
			   return $ret;
		   }

		  
		   function setCoverImage($id)
           {
              $pi = ProductImages::where('id',$id)->first();
            
              if($pi != null)
               {
				   $formerPi = ProductImages::where('sku',$pi->sku)
			              ->where('cover',"yes")->first();
                   
				   if($formerPi != null)
				   {
					   $formerPi->update(['cover' => "no"]);
				   }
				   
				  $pi->update(['cover' => "yes"]);
               }                         
                                                      
           }
		   
		   function getCloudinaryImage($dt)
		   {
			   $ret = [];
                  //dd($dt);       
               if(is_null($dt)) { $ret = "img/no-image.png"; }
               
			   else
			   {
				    $ret = "https://res.cloudinary.com/dahkzo84h/image/upload/v1585236664/".$dt;
                }
				
				return $ret;
		   }
		   
		   function getCloudinaryImages($dt)
		   {
			   $ret = [];
                  //dd($dt);       
               if(count($dt) < 1) { $ret = ["img/no-image.png"]; }
               
			   else
			   {
                   $ird = $dt[0]['url'];
				   if($ird == "none")
					{
					   $ret = ["img/no-image.png"];
					}
				   else
					{
                       for($x = 0; $x < count($dt); $x++)
						 {
							 $ird = $dt[$x]['url'];
                            $imgg = "https://res.cloudinary.com/dahkzo84h/image/upload/v1585236664/".$ird;
                            array_push($ret,$imgg); 
                         }
					}
                }
				
				return $ret;
		   }
		
		   
		     function updateUser($data)
           {		

				$uu = User::where('id', $data['xf'])->first();
				
				if(!is_null($uu))				
				{
					$uu->update(['fname' => $data['fname'], 
                                                      'lname' => $data['lname'],
                                                     'email' => $data['email'],
                                                'phone' => $data['phone'],
                                              'status' => $data['status'] 
                                                      ]);	
				}
					
           }
		   
		   function isAdmin($user)
           {
           	$ret = false; 
               if($user->role === "admin" || $user->role === "su") $ret = true; 
           	return $ret;
           }
		   
		   function generateSKU()
           {
           	$ret = "ACE".rand(1,9999)."LX".rand(1,999);
                                                      
                return $ret;
           }
		   
		   
		   function createProduct($data)
           {
           	$sku = $this->generateSKU();
               
           	$ret = Products::create(['name' => $data['name'],                                                                                                          
                                                      'sku' => $sku, 
                                                      'qty' => $data['qty'],                                                       
                                                      'added_by' => $data['user_id'],
													  'in_catalog' => 'no',
                                                      'status' => "enabled", 
                                                      ]);
                                                      
                 $data['sku'] = $ret->sku;                         
                $pd = $this->createProductData($data);
				$ird = "none";
				$irdc = 0;
				if(isset($data['ird']) && count($data['ird']) > 0)
				{
					foreach($data['ird'] as $i)
                    {
                    	$this->createProductImage(['sku' => $data['sku'], 'url' => $i['public_id'], 'cover' => $i['ci'], 'irdc' => "1"]);
                    }
				}
                
                return $ret;
           }
           function createProductData($data)
           {
           	$in_stock = (isset($data["in_stock"])) ? "new" : $data["in_stock"];
           
           	$ret = ProductData::create(['sku' => $data['sku'],                                                                                                          
                                                      'description' => $data['description'], 
                                                      'amount' => $data['amount'],                                                      
                                                      'category' => $data['category'],                                                                                                        
                                                      'in_stock' => $in_stock                                              
                                                      ]);
                                                      
                return $ret;
           }
         
           function createProductImage($data)
           {
			   $cover = isset($data['cover']) ? $data['cover'] : "no";
           	$ret = ProductImages::create(['sku' => $data['sku'],                                                                                                          
                                                      'url' => $data['url'], 
                                                      'irdc' => $data['irdc'], 
                                                      'cover' => $cover, 
                                                      ]);
                                                      
                return $ret;
           }
		   
		   function createDiscount($data)
           {
			   $uid = "";
			   
			   if($data['type'] == "single") $uid = $data['sku'];
			   else if($data['type'] == "category") $uid = $data['category'];
			   
           	$ret = Discounts::create(['uid' => $uid,                                                                                                          
                                                      'code' => $data['code'], 
                                                      'discount_type' => $data['discount_type'], 
                                                      'discount' => $data['discount'], 
                                                      'type' => $data['type'], 
                                                      'status' => $data['status'], 
                                                      ]);
                                                      
                return $ret;
           }
		   
		   function getDiscounts($id,$type="product")
           {
           	$ret = [];
			
			 if($id == "all")
			 {
				 $discounts = Discounts::where('id','>',"0")->get();
             }
			 else
			 {
               $discounts = Discounts::where('uid',$id)
			                 ->orWhere('type',$type)
							 ->where('status',"enabled")->get(); 
			 }
			 
			 
              if($discounts != null)
               {
				  foreach($discounts as $d)
				  {
					$temp = [];
				    $temp['id'] = $d->id;
				    $temp['uid'] = $d->uid;
				    $temp['code'] = $d->code;
				    $temp['discount_type'] = $d->discount_type;
				    $temp['discount'] = $d->discount;
				    $temp['type'] = $d->type;
					if($temp['type'] == "category") $temp['category'] = $this->getCategory($temp['uid']);
				    $temp['status'] = $d->status;
				    array_push($ret,$temp);  
				  }
               }                         
                                                      
                return $ret;
           }
		   
		     function getDiscountPrices($amount,$discounts)
		   {
			   $newAmount = 0;
						$dsc = [];
                     
					 if(count($discounts) > 0)
					 { 
						 foreach($discounts as $d)
						 {
							 $temp = 0;
							 $val = $d['discount'];
							 
							 switch($d['discount_type'])
							 {
								 case "percentage":
								   $temp = floor(($val / 100) * $amount);
								 break;
								 
								 case "flat":
								   $temp = $val;
								 break;
							 }
							 
							 array_push($dsc,$temp);
						 }
					 }
				   return $dsc;
		   }

		   function getDiscount($id)
           {
           	$ret = [];
				$disc = Discounts::where('id',$id)->first();              
							 
					if($disc != null)
					{
					
							$temp = [];
				            $temp['id'] = $disc->id;
				            $temp['uid'] = $disc->uid;
				            $temp['code'] = $disc->code;
				            $temp['discount_type'] = $disc->discount_type;
				            $temp['discount'] = $disc->discount;
				            $temp['type'] = $disc->type;
							if($temp['type'] == "category") $temp['category'] = $this->getCategory($temp['uid']);
				            $temp['status'] = $disc->status;
							$ret = $temp;
					}                      
                                                      
                return $ret;
           }
		   
		   function updateProduct($data)
           {
           	$ret = [];
              $p = Products::where('id',$data['xf'])
			                 ->orWhere('sku',$data['xf'])->first();
              
			  //dd($data);
              if($p != null)
               {
				  $p->update([
				  'qty' => $data['qty'],
				    'status' => $data['status']
				  ]);
				  
				  $pd = ProductData::where('sku',$p->sku)->first();
				  if($pd != null)
				  {
					  $pd->update([
					    'category' => $data['category'],
					    'in_stock' => $data['in_stock'],
					    'amount' => $data['amount'],
					    'description' => $data['description'],
					  ]);
				  }
				  
				  //images
				  if(isset($data['ird']) && count($data['ird']) > 0)
				{
					foreach($data['ird'] as $url)
                    {
                    	$this->createProductImage(['sku' => $p->sku, 'url' => $url, 'irdc' => "1"]);
                    }
				}

                  //discounts
                  if($data['add_discount'] == "yes")
				  {
					  $disc = ['sku' => $p->sku,
					           'discount_type' => $data['discount_type'],
							   'discount' => $data['discount'],
							   'type' => 'single',
							   'status' => "enabled"
							   ];
					  $discount = $this->createDiscount($disc);
				  }				  
				 
				 
				 //update catalog here
				  /**
				 $cid = env('FACEBOOK_CATALOG_ID');
		        $url = "https://graph.facebook.com/v10.0/".$cid."/batch";
				$reqs = [];
				 
				 $temp = [
		                  'method' => "UPDATE",
			              'retailer_id' => $p->sku,
			              'data' => [
			                'amount' => $data['amount'] * 100,
			                'description' => $data['description']
			              ]
			           ];
					   array_push($reqs,$temp);
					   
					   $dtt = [
		           'access_token' => $tk,
		           'requests' => $reqs
		       ]; 
			   $data = [
		        'type' => "json",
		        'data' => $dtt
		       ];
		      
			   $ret = $this->callAPI($url,"POST",$data);
			   $rt = json_decode($ret);
			   #dd($rt);
			   if(isset($rt->handles))
			   {
				   $handles = $rt->handles;
				   
				  // foreach($products as $p)
				   //{
					//   $pp = Products::where('sku',$p->sku)->first();
					  // if($pp != null) $pp->update(['in_catalog' => "yes"]);
				   //}
				 
			   }
			   **/
               }                         
                                                      
                return "ok";
           }

		   function disableProduct($id,$def=false)
           {
           	$ret = [];
              $p = Products::where('id',$id)
			                 ->orWhere('sku',$id)->first();
              
			  //dd($data);
              if($p != null)
               {
				  $p->update([		
				    'status' => "disabled"
				  ]);
               }                         
                                                      
                return "ok";
           } 
		   
		   function deleteProduct($id,$def=false)
           {
           	$ret = [];
              $p = Products::where('id',$id)
			                 ->orWhere('sku',$id)->first();
              
			  //dd($data);
              if($p != null)
               {
				  $pis = ProductImages::where('sku',$id)->get();
				  
				  if($pis != null)
				  {
					foreach($pis as $pi) $pi->delete();  
				  }
				  
				  $pd = ProductData::where('sku',$id)->first();
				  
				  if($pd != null) $pd->delete();
				  
				  $p->delete();
               }                         
                                                      
                return "ok";
           } 
		   
		    function updateDiscount($data)
           {
           	$ret = [];
			$uid = "";
			   
			   if($data['type'] == "single") $uid = $data['sku'];
			   else if($data['type'] == "category") $uid = $data['category'];
			   
              $disc = Discounts::where('id',$data['xf'])->first();
              
			  //dd($data);
              if($disc != null)
               {
				  $disc->update([
				  'type' => $data['type'],
				  'code' => $data['code'],
				  'uid' => $uid,
				  'discount_type' => $data['discount_type'],
				  'discount' => $data['discount'],
				    'status' => $data['status']
				  ]);
				  
				 
               }                         
                                                      
                return "ok";
           }
		   
		   function deleteDiscount($xf)
           {
           	$ret = [];
              $d = Discounts::where('id',$xf)->first();
              
			  //dd($data);
              if($d != null)
               {
				 $d->delete();
               }                         
                                                      
                return "ok";
           }
		   
		   function deleteProductImage($xf)
           {
           	$ret = [];
              $pi = ProductImages::where('id',$xf)->first();
              
			  //dd($data);
              if($pi != null)
               {
				  //$this->deleteCloudImage($pi->delete_token);
				 $pi->delete();
               }                         
                                                      
                return "ok";
           }
		   
		  function deleteCloudImage($id)
          {
          	$dt = ['cloud_name' => "dahkzo84h",'invalidate' => true];
          	$rett = \Cloudinary\Uploader::destroy($id,$dt);
                                                     
             return $rett; 
         }
		 
		 function resizeImage($res,$size)
		 {
			  $ret = Image::make($res)->resize($size[0],$size[1])->save(sys_get_temp_dir()."/upp");			   
              // dd($ret);
			   $fname = $ret->dirname."/".$ret->basename;
			   $fsize = getimagesize($fname);
			  return $fname;		   
		 }
		   
		    function uploadCloudImage($path)
          {
          	$ret = [];
          	$dt = ['cloud_name' => "dahkzo84h"];
              $preset = "tsh1rffm";
			  $cloudinary = new Cloudinary();
          	$rett = $cloudinary->uploadApi()->unsignedUpload($path,$preset,$dt);
                                                      
             return $rett; 
         }
		 
		  function addCategory($data)
           {
           	$category = Categories::create([
			   'name' => $data['name'],
			   'category' => $data['category'],
			   'special' => $data['special'],
			   'gpc' => $data['gpc'],
			   'status' => $data['status'],
			]);                          
            return $ret;
           }
		   
		   function getCategories()
           {
           	$ret = [];
           	$categories = Categories::where('id','>','0')->get();
              // dd($cart);
			  
              if($categories != null)
               {           	
               	foreach($categories as $c) 
                    {
						$temp = [];
						$temp['id'] = $c->id;
						$temp['name'] = $c->name;
						$temp['category'] = $c->category;
						$temp['special'] = $c->special;
						$temp['gpc'] = $c->gpc;
						$temp['status'] = $c->status;
						array_push($ret,$temp);
                    }
                   
               }                                 
                                                      
                return $ret;
           }
		   
		   function getCategory($id)
           {
           	$ret = [];
           	$c = Categories::where('id',$id)
                                    ->orWhere('category',$id)->first();
              // dd($cart);
			  
              if($c != null)
               {           	
						$temp = [];
						$temp['id'] = $c->id;
						$temp['name'] = $c->name;
						$temp['category'] = $c->category;
						$temp['special'] = $c->special;
						$temp['gpc'] = $c->gpc;
						$temp['status'] = $c->status;
						$ret = $temp;
               }                                 
                                                      
                return $ret;
           }
		   
		   function createCategory($data)
           {
           	$ret = Categories::create(['name' => ucwords($data['category']),                                                                                                          
                                                      'category' => $data['category'],                                                      
                                                      'special' => $data['special'],  
                                                      'gpc' => $data['gpc'],                                                      
                                                      'status' => $data['status'], 
                                                      ]);
            
                
                return $ret;
           }
		   
		   function updateCategory($data)
           {
			  $c = Categories::where('id',$data['xf'])->first();
			 
			  $special = isset($data['special']) ? $data['special'] : "";
			 
			if($c != null)
			{
				$c->update(['name' => ucwords($data['category']),                                                                                                          
                                                      'category' => $data['category'],                                                      
                                                      'special' => $special,
                                                      'gpc' => $data['gpc'],                                                        
                                                      'status' => $data['status']
				
				]);
			}

                return "ok";
           }
		   
		   function createAd($data)
           {
           	$ret = Ads::create(['img' => $data['img'], 
                                                      'type' => $data['type'], 
                                                      'status' => $data['status'] 
                                                      ]);
                                                      
                return $ret;
           }

            function getAds($type="wide-ad")
		   {
			   $ret = [];
			   $ads = Ads::where('id',">",'0')->get();
			   #dd($ads);
			   if(!is_null($ads))
			   {
				   foreach($ads as $ad)
				   {
					   $temp = [];
					   $temp['id'] = $ad->id;
					   $img = $ad->img;
					   $temp['img'] = $this->getCloudinaryImage($img);
					   $temp['type'] = $ad->type;
					   $temp['status'] = $ad->status;
					   array_push($ret,$temp);
				   }
			   }
			   
			   return $ret;
		   }	   

		   function getAd($id)
		   {
			   $ret = [];
			   $ad = Ads::where('id',$id)->first();
			   #dd($ads);

			   if(!is_null($ad))
			   {
					   $temp = [];
					   $temp['id'] = $ad->id;
					   $img = $ad->img;
					   $temp['img'] = $this->getCloudinaryImage($img);
					   $temp['type'] = $ad->type;
					   $temp['status'] = $ad->status;
					   $ret = $temp;
			   }
			   
			   return $ret;
		   }	 

            function updateAd($data)
           {
			  $ad = Ads::where('id',$data['xf'])->first();
			 
			 
			if($ad != null)
			{
				$ad->update(['type' => $data['type'],                                                                                                                                                               
                                                      'status' => $data['status']
				
				]);
			}

                return "ok";
           }		   
		  
		  
		    function createReview($user,$data)
           {
			   $userId = $user == null ? $this->generateTempUserID() : $user->id;
           	$ret = Reviews::create(['user_id' => $userId, 
                                                      'sku' => $data['sku'], 
                                                      'rating' => $data['rating'],
                                                      'name' => $data['name'],
                                                      'review' => $data['review'],
													  'status' => "pending",
                                                      ]);
                                                      
                return $ret;
           }
		   
		  function getReviews()
           {
           	$ret = [];
              $reviews = Reviews::where('id','>',"0")->get();
              $reviews = $reviews->sortByDesc('created_at');
			  
              if($reviews != null)
               {
				  foreach($reviews as $r)
				  {
					  $temp = [];
					  $temp['id'] = $r->id;
					  $temp['user_id'] = $r->user_id;
					  $temp['sku'] = $r->sku;
					  $temp['rating'] = $r->rating;
					  $temp['name'] = $r->name;
					  $temp['review'] = $r->review;
					  $temp['status'] = $r->status;
					  array_push($ret,$temp);
				  }
               }                         
                                  
                return $ret;
           }
		   
		   function getReview($id)
           {
           	$ret = [];
              $r = Reviews::where('id',$id)->first();
 
              if($r != null)
               {
				  
					  $temp = [];
					  $temp['id'] = $r->id;
					  $temp['user_id'] = $r->user_id;
					  $temp['sku'] = $r->sku;
					  $temp['rating'] = $r->rating;
					  $temp['name'] = $r->name;
					  $temp['review'] = $r->review;
					  $temp['status'] = $r->status;
					  $ret = $temp;
               }                         
                                  
                return $ret;
           }
		   
		    function updateReview($data)
           {
			  $r = Reviews::where('id',$data['xf'])->first();
			   #dd($data);
			 
			if($r != null)
			{
				$r->update(['name' => $data['name'],                                                                                                                                                               
                                                      'status' => $data['status']
				
				]);
			}

                return "ok";
           }
		   
		    function createOrderReview($data)
           {
			 #  $userId = $user == null ? $this->generateTempUserID() : $user->id;
           	$ret = OrderReviews::create(['reference' => $data['ref'], 
                                                      'caa' => $data['caa'], 
                                                      'daa' => $data['daa'],
                                                      'caa_img' => $data['img'],
                                                      'rating' => $data['rating'],
                                                      'comment' => $data['comment'],
                                                      'status' => "pending",
                                                      ]);
                                                      
                return $ret;
           }
		   
		   function getOrderReviews()
           {
           	$ret = [];
              $reviews = OrderReviews::where('id','>',0)->get();
              $reviews = $reviews->sortByDesc('created_at');	
			  
              if($reviews != null)
               {
				  foreach($reviews as $r)
				  {
					  $temp = [];
					  $temp['id'] = $r->id;
					  $temp['reference'] = $r->reference;
					  $temp['caa'] = $r->caa;
					  $temp['img'] = $this->getCloudinaryImage($r->caa_img);
					 $temp['daa'] = $r->daa;
					  $temp['comment'] = $r->comment;
					  $temp['status'] = $r->status;
					  array_push($ret,$temp);
				  }
               }                         
                                  
                return $ret;
           }
		   
		   function getOrderReview($ref)
           {
           	$ret = [];
              $review = OrderReviews::where('ref',$ref)->first();
             
              if($review != null)
               {
				  
					  $temp = [];
					  $temp['id'] = $r->id;
					  $temp['reference'] = $r->reference;
					  $temp['caa'] = $r->caa;
					  $temp['img'] = $this->getCloudinaryImage($r->caa_img);
					 $temp['daa'] = $r->daa;
					  $temp['comment'] = $r->comment;
					  $temp['status'] = $r->status;
					  $ret = $temp;
               }                         
                                  
                return $ret;
           }
		   
		   function updateOrderReview($data)
           {
			   $ret = "error";
			  $r = OrderReviews::where('reference',$data['xf'])->first();
			  # dd($r);
			 
			if($r != null)
			{
				$rrr = [];
			   if(isset($data['caa'])) $rrr['caa'] = $data['caa'];
			   if(isset($data['daa'])) $rrr['daa'] = $data['daa'];
			   if(isset($data['img'])) $rrr['img'] = $data['img'];
			   if(isset($data['comment'])) $rrr['comment'] = $data['comment'];
			   if(isset($data['status'])) $rrr['status'] = $data['status'];
			   #dd($rrr);
				$r->update($rrr);
				$ret = "ok";
			}

                return $ret;
           }
		   
		    function createBanner($data)
           {
			   $copy = isset($data['copy']) ? $data['copy'] : "";
           	$ret = Banners::create(['img' => $data['img'], 
                                                      'title' => $data['title'], 
                                                      'subtitle' => $data['subtitle'], 
                                                      'copy' => $copy, 
                                                      'status' => $data['status'] 
                                                      ]);
                                                      
                return $ret;
           }

            function getBanners()
		   {
			   $ret = [];
			   $banners = Banners::where('id',">",'0')->get();
			   #dd($ads);
			   if(!is_null($banners))
			   {
				   foreach($banners as $b)
				   {
					   $temp = [];
					   $temp['id'] = $b->id;
					   $img = $b->img;
					   $temp['img'] = $this->getCloudinaryImage($img);
					   $temp['title'] = $b->title;
					   $temp['subtitle'] = $b->subtitle;
					   $temp['copy'] = $b->copy;
					   $temp['status'] = $b->status;
					   array_push($ret,$temp);
				   }
			   }
			   
			   return $ret;
		   }	   

		   function getBanner($id)
		   {
			   $ret = [];
			   $b = Banners::where('id',$id)->first();
			   #dd($banners);
			   if(!is_null($b))
			   {
					   $temp = [];
					   $temp['id'] = $b->id;
					   $img = $b->img;
					   $temp['img'] = $this->getCloudinaryImage($img);
					   $temp['title'] = $b->title;
					   $temp['subtitle'] = $b->subtitle;
					   $temp['copy'] = $b->copy;
					   $temp['status'] = $b->status;
					   $ret = $temp;
			   }
			   
			   return $ret;
		   }	 

            function updateBanner($data)
           {
			  $b = Banners::where('id',$data['xf'])->first();
			 
			 
			if($b != null)
			{
				$rr = ['status' => $data['status']];
				if(isset($data['img'])) $rr['img'] = $data['img'];
				$b->update($rr);
			}

                return "ok";
           }
		   
		   function deleteBanner($xf)
           {
           	$ret = [];
              $b = Banners::where('id',$xf)->first();
              
			  //dd($data);
              if($b != null)
               {
				 // $this->deleteCloudImage($pi->url);
				 $b->delete();
               }                         
                                                      
                return "ok";
           }

		   function getDashboardStats()
           {
			   $ret = [];
			   
			  //total products
			  $ret['total'] = Products::where('id','>',"0")->count();
			  $ret['enabled'] = Products::where('status',"enabled")->count();
			  $ret['disabled'] = Products::where('status',"disabled")->count();
			  $ret['o_total'] = Orders::where('id','>',"0")->count();
			  $ret['o_paid'] = Orders::where('id','>',"0")->where('status',"paid")->count();
			  $ret['o_unpaid'] = Orders::where('id','>',"0")->where('status',"unpaid")->count();
			  $ret['o_today'] = Orders::whereDate('created_at',date("Y-m-d"))->count();
			  $ret['o_month'] = Orders::whereMonth('created_at',date("m"))->count();
			
              return $ret;
           }

		   function getOrderStats()
           {
			   $ret = [];
			   
			  //total products
			  $ret['unpaid'] = Orders::whereIn('status',["unpaid","pod"])->count();
			  $ret['paid'] = Orders::where('status',"paid")->count();
			  $ru = 0;
			  foreach(Orders::where(['status' => "paid"])->cursor() as $o)
			  {
				  if($this->getCurrentTracking($o->reference) == null) ++$ru;
			  }
			  $ret['untracked'] = 0;
			  
			
              return $ret;
           }
		   
		   function getProfits()
		   {
			   $ret = [];
			   
			    //total profits
				$ret['total'] = Orders::where('id','>',"0")->where('status',"paid")->sum('amount');
				$ret['today'] = Orders::whereDate('created_at',date("Y-m-d"))->where('status',"paid")->sum('amount');
				$ret['month'] = Orders::whereMonth('created_at',date("m"))
				                ->whereYear('created_at',date("Y"))
				                ->where('status',"paid")->sum('amount');
				
				return $ret;
		   }
		   
		   
		   function createTracking($dt)
		   {
			   $status = $dt['status'];
			   $description = $this->deliveryStatuses[$status];
			   $ret = Trackings::create(['user_id' => $dt['user_id'],
			                          'reference' => $dt['reference'],
			                          'description' => $description,
			                          'status' => $status
			                 ]);
			  return $ret;
		   }

           function getTrackings($reference="")
		   {
			   $ret = [];
			   if($reference == "") $trackings = Trackings::where('id','>',"0")->get();
			   else $trackings = Trackings::where('reference',$reference)->get();
			   
			   if(!is_null($trackings))
			   {
				  $trackings = $trackings->sortByDesc('created_at');
				   foreach($trackings as $t)
				   {
					   $temp = [];
					   $temp['id'] = $t->id;
					   $temp['user_id'] = $t->user_id;
					   $temp['reference'] = $t->reference;
					   $temp['description'] = $t->description;
					   $temp['status'] = $t->status;
					   $temp['date'] = $t->created_at->format("jS F, Y h:i A");
					   array_push($ret,$temp);
				   }
			   }
			   
			   return $ret;
		   }

		   function updateStock($s,$q)
		   {
			   $p = Products::where('sku',$s)->first();
			   
			   if($p != null)
			   {
				   $oldQty = ($p->qty == "" || $p->qty < 0) ? 0: $p->qty;
				   $qty = $p->qty - $q;
				   if($qty < 0) $qty = 0;
				   $p->update(['qty' => $qty]);
			   }
			   
			   //update product stock on catalog here
		   }
		   
		   function clearNewUserDiscount($u)
		   {
			  # dd($user);
			  if(!is_null($u))
			  {
			     $d = Discounts::where('sku',$u->id)
			                 ->where('type',"user")
							 ->where('discount',$this->newUserDiscount)->first();
			   
			     if(!is_null($d))
			     {
				   $d->delete();
			     }
			  }
		   }		   


            function addOrder($user,$data,$gid=null)
           {
			   $cart = [];
			   $gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";  
           	   $order = $this->createOrder($user, $data);
			   
                if($user == null && $gid != null) $cart = $this->getCart($user,$gid);
			 else $cart = $this->getCart($user);
			 #dd($cart);
			 
               #create order details
               foreach($cart as $c)
               {
				   $dt = [];
                   $dt['sku'] = $c['product']['sku'];
				   $dt['qty'] = $c['qty'];
				   $dt['order_id'] = $order->id;
				   $this->updateStock($dt['sku'],$dt['qty']);
                   $oi = $this->createOrderItems($dt);                    
               }

               #send transaction email to admin
               //$this->sendEmail("order",$order);  
               
			   
			   //clear cart
			   //$this->clearCart($user);
			   
			   //if new user, clear discount
			   $this->clearNewUserDiscount($user);
			   return $order;
           }

           function createOrder($user, $dt)
		   {
			   #dd($dt);
			   //$ref = $this->helpers->getRandomString(5);
			   $psref = isset($dt['ps_ref']) ? $dt['ps_ref'] : "";
			   $c = isset($dt['courier_id']) ? $dt['courier_id'] : "";
			   $pt = isset($dt['payment_type']) ? $dt['payment_type'] : "";
			  
			  if(is_null($user))
			   {
				   $gid = isset($_COOKIE['gid']) ? $_COOKIE['gid'] : "";
				   $anon = AnonOrders::create(['email' => $dt['email'],
				                     'reference' => $dt['ref'],
				                     'name' => $dt['name'],
				                     'phone' => $dt['phone'],
				                     'address' => $dt['address'],
				                     'city' => $dt['city'],
				                     'state' => $dt['state'],
				             ]);
				   
				   $ret = Orders::create(['user_id' => "anon",
			                          'reference' => $dt['ref'],
			                          'ps_ref' => $psref,
			                          'amount' => $dt['amount'],
			                          'type' => $dt['type'],
			                          'courier_id' => $c,
			                          'payment_type' => $pt,
			                          'notes' => $dt['notes'],
			                          'status' => $dt['status'],
			                 ]); 
			   }
			   
			   else
			   {
				 $ret = Orders::create(['user_id' => $user->id,
			                          'reference' => $dt['ref'],
			                          'ps_ref' => $psref,
			                          'amount' => $dt['amount'],
			                          'type' => $dt['type'],
			                          'courier_id' => $c,
			                          'payment_type' => $pt,
			                          'notes' => $dt['notes'],
			                          'status' => $dt['status'],
			                 ]);   
			   }
			   
			  return $ret;
		   }

		   function createOrderItems($dt)
		   {
			   $ret = OrderItems::create(['order_id' => $dt['order_id'],
			                          'sku' => $dt['sku'],
			                          'qty' => $dt['qty']
			                 ]);
			  return $ret;
		   }
		   
		   function isSouthWestState($s)
		   {
			   $ret = false;
			   $sw = ["ekiti","lagos","ogun","ondo","osun","oyo"];
			   
			   foreach($sw as $sww)
			   {
				   if(strtolower($s) == $sww) $ret = true;
			   }
			   
			   return $ret;
		   }
		   
		    function getDeliveryFee($u=null,$type="user")
		   {
			    $s1 = Settings::where('name',"delivery1")->first();
			    $s2 = Settings::where('name',"delivery2")->first();
			   
			   $state = "";
			   
			   if($s1 == null || $s2 == null)
			   {
				   if($s1 == null) $delivery1 = 1000;
				   if($s2 == null) $delivery2 = 2000;
			   }
			   else
			   {
				   $delivery1 = $s1->value;
				   $delivery2 = $s2->value;
			   }
			   $ret = $delivery2;
			   
			   switch($type)
			   {
				 case "user":
				 if(!is_null($u))
			     {
				   $shipping = $this->getShippingDetails($u);
                   $s = $shipping[0];				  
                   $state = $s['state'];
			     }
                 break;

                 case "state":
				  $state = $u;
                 break;				 
			   }
			   
			   if($state != null && $state != "")
			   {
				 if($this->isSouthWestState($state)) $ret = $delivery1;   
			   }
			   
			    
			   return $ret;
		   }
			

           function getOrderTotals($items)
           {
           	$ret = ["subtotal" => 0, "delivery" => 0, "items" => 0];
              #dd($items);
              if($items != null && count($items) > 0)
               {    
		          $oid = $items[0]['order_id'];
                 $o = Orders::where('id',$oid)->first();		   
               	foreach($items as $i) 
                    {
                    	if(count($i['product']) > 0)
                        {
						  $amount = $i['product']['pd']['amount'];
						  $qty = $i['qty'];
                      	$ret['items'] += $qty;
						  $ret['subtotal'] += ($amount * $qty);
                       }	
                    }
                   
				   $c = $this->getCourier($o->courier_id);
				   	$ret['delivery'] = isset($c['price']) ? $c['price'] : "1000";
                  
               }                                 
                                                      
                return $ret;
           }

           function getOrders($params=[])
           {
           	$ret = [];

			  $orders = Orders::where('id','>',"0")->get();
			  $orders = $orders->sortByDesc('created_at');
			  #dd($uu);
              if($orders != null)
               {
               	  foreach($orders as $o) 
                    {
                    	$temp = $this->getOrder($o->reference,$params);
                        array_push($ret, $temp); 
                    }
               }                                 
              			  
                return $ret;
           }
		   
		   function getOrder($ref,$params=[])
           {
           	$ret = [];

			  $o = Orders::where('id',$ref)
			                  ->orWhere('reference',$ref)->first();
			  #dd($uu);
              if($o != null)
               {
				  $temp = [];
                  $temp['id'] = $o->id;
                  $temp['user_id'] = $o->user_id;
                  $temp['reference'] = $o->reference;
                  $temp['amount'] = $o->amount;
                  $temp['type'] = $o->type;
				  $temp['courier_id'] = $o->courier_id;
				  $c = $this->getCourier($o->courier_id);
                  $temp['courier'] = $c;
                  $temp['payment_type'] = $o->payment_type;
                  $temp['notes'] = $o->notes;
                  $temp['status'] = $o->status;
                  $temp['current_tracking'] = $this->getCurrentTracking($o->reference);
                  $temp['items'] = $this->getOrderItems($o->id);
                  $temp['totals'] = $this->getOrderTotals( $temp['items']);
				  if($o->user_id == "anon")
				  {
						$anon = $this->getAnonOrder($o->reference,false);
						$temp['anon'] = $anon;
						$temp['totals']['delivery'] = isset($c['price']) ? $c['price'] : "1000";;  
				  }
				  else
				  {
					  $temp['user'] = $this->getUser($o->user_id);
				  }
                  $temp['date'] = $o->created_at->format("jS F, Y");
                  if(isset($params['sd']) && $params['sd']) $temp['sd'] = $o->created_at->format("Y-m-d");
                  $ret = $temp; 
               }                                 
              		#dd($ret);	  
                return $ret;
           }


           function getOrderItems($id)
           {
           	$ret = [];

			  $items = OrderItems::where('order_id',$id)->get();
			  #dd($uu);
              if($items != null)
               {
               	  foreach($items as $i) 
                    {
						$temp = [];
                    	$temp['id'] = $i->id; 
                    	$temp['order_id'] = $i->order_id; 
                        $temp['sku'] = $i->sku; 
                        $temp['product'] = $this->getProduct($i->sku); 
                        $temp['qty'] = $i->qty; 
                        array_push($ret, $temp); 
                    }
               }                                 
              			  
                return $ret;
           }

           function updateOrder($data)
           {
			  $o = Orders::where('id',$data['xf'])->first();
			 
			 
			if($o != null)
			{
				$dt = [
				 'status' => $data['status']
				];
				
				if($data['email'] != $data['fxx'])
				{
					$em = $data['email'];
					
					if($o->user_id == "anon")
					{
						$ao = AnonOrders::where('reference',$o->reference)->first();
						if($ao != null) $ao->update(['email' => $em]);
					}
					else
					{
						#$u = 
					}
				}
				
				$o->update($dt);
			}

                return "ok";
           }		   
		
		
		 function getPasswordResetCode($user)
           {
           	$u = $user; 
               
               if($u != null)
               {
               	//We have the user, create the code
                   $code = bcrypt(rand(125,999999)."rst".$u->id);
               	$u->update(['reset_code' => $code]);
               }
               
               return $code; 
           }
           
           function verifyPasswordResetCode($code)
           {
           	$u = User::where('reset_code',$code)->first();
               
               if($u != null)
               {
               	//We have the user, delete the code
               	$u->update(['reset_code' => '']);
               }
               
               return $u; 
           }
		   
		   function confirmPayment($id)
           {
            $o = $this->getOrder($id);
            $items = [];
            
             # dd($o);
               if(count($o) > 0)
               {
               	$items = $o['items'];
				   if($o['user_id'] == "anon")
				   {
					   $u = $o['anon'];
					   $shipping = [
					     'address' => $u['address'],
					     'city' => $u['city'],
					     'state' => $u['state']
					   ];
				   }
				   else
				   {
					   $u = $this->getUser($o['user_id']);
					   $sd = $this->getShippingDetails($u['id']);
					   $shipping = $sd[0];
				   }
				   
				  # dd($u);
               	//We have the user, update the status and notify the customer
				$oo = Orders::where('reference',$o['reference'])->first();
               	if(!is_null($oo)) $oo->update(['status' => 'paid']);
				
				//update each product stock for bank payments
				if($o["payment_type"] == "bank")
				{
				foreach($items as $i)
               {
               	if(count($i['product']) > 0)
                   {
                   	$sku = $i['product']['sku'];
				       $qty = $i['qty'];
				       $this->updateStock($sku,$qty);                   
                   }
                   
               }
               }
               
				//$ret = $this->smtp;
				$ret = $this->getCurrentSender();
				$ret['order'] = $o;
				$ret['shipping'] = $shipping;
				$ret['name'] = $o['user_id'] == "anon" ? $u['name'] : $u['fname'];
				$ret['subject'] = "Your payment for order #: ".$o['reference']." has been confirmed";
				if($o['type'] == "pod") $ret['subject'] = "Your part payment for order #: ".$o['reference']." has been confirmed";
		        $ret['phone'] = $u['phone'];
		        $ret['em'] = $u['email'];
				$ret['user'] = $u['email'];
		        $this->sendEmailSMTP($ret,"emails.confirm-payment");
				
				//$ret = $this->smtp;
				$ret = $this->getCurrentSender();
				$ret['order'] = $o;
				$ret['shipping'] = $shipping;
				$ret['user'] = $u['email'];
				$ret['name'] = $o['user_id'] == "anon" ? $u['name'] : $u['fname']." ".$u['lname'];
				$ret['phone'] = $u['phone'];
		        $ret['subject'] = "URGENT: Received payment for order ".$o['reference']." via bank";
		        if($o['type'] == "pod") $ret['subject'] = "URGENT: Received part payment for order ".$o['reference']." via POD";
		        
		        $ret['em'] = $this->adminEmail;
		        $this->sendEmailSMTP($ret,"emails.payment-alert");
				$ret['em'] = $this->suEmail;
		        $this->sendEmailSMTP($ret,"emails.payment-alert");
               }
               
               return $o; 
           }
		   
		   function deleteOrder($id)
           {
			  $o = Orders::where('id',$id)
			           ->OrWhere('reference',$id)->first();
					   
			  $a = AnonOrders::where('id',$id)
			           ->OrWhere('reference',$id)->first();
			 
			 
			if($o != null)
			{
				$items = OrderItems::where('order_id',$o->id)->get();
			    if($items != null)
                 {
                   foreach($items as $i) 
                    {
                    	$i->delete();
                    }
                }
                
                $o->delete();
				if($a != null) $a->delete();
			}

                return "ok";
           }


          function manageUserStatus($dt)
		  {
			  $user = User::where('id',$dt['id'])
			              ->orWhere('email',$dt['id'])->first();
			  
			  if($user != null)
			  {
				  $val = $dt['action'] == "enable" ? "enabled" : "disabled";
				  $user->update(['status' => $val]);
			  }
			  
			  return "ok";
		  }
		
		  function updateTracking($oo,$action)
         {
			 $o = isset($oo->reference) ? $oo->reference : $oo;
         	$order = $this->getOrder($o);
			#dd($order);
                    if(count($order) > 0)
                    {
                    	if($order['user_id'] == "anon")
                        {
                        	$u = $order['anon'];
                        }
                        else
                        {
                        	$u = $this->getUser($order['user_id']);
                        }
                    	$t = [
                         'user_id' => $order['user_id'],
                         'reference' => $o,
                         'status' => $action
                         ];
                         
                         $this->createTracking($t);
                         
                         //$ret = $this->smtp;
						 //$ret = $this->getCurrentSender();
						 $ret = [];
						
				         $ret['order'] = $order;
				         $ret['tracking'] = $this->deliveryStatuses[$action];
				         $ret['name'] = $order['user_id'] == "anon" ? $u['name'] : $u['fname']." ".$u['lname'];
		                 $ret['subject'] = "New update for order ".$o;
		                 $ret['em'] = $u['email'];
				//$this->sendEmailSMTP($ret,"emails.tracking-alert");
				         $this->sendEmailAPI($ret,'tracking-alert');
                    }
         }

          function bulkUpdateTracking($data)
		  {
			$dt = json_decode($data['dt']);
			$action = $data['action'];
			
			#dd($dt);
			 
			foreach($dt as $o)
            {
            	if($o->selected)
                {
                	$this->updateTracking($o,$action);
                }
            }
			  
			  
			  return "ok";
		  }	

         function getCurrentTracking($reference)
         {
         	$ret = null;
         	$trackings = $this->getTrackings($reference);
             
             if(count($trackings) > 0)
             {
             	$ret = $trackings[0];
             }
             
             return $ret;
        }

         function bulkConfirmPayment($data)
		  {
			$dt = json_decode($data['dt']);
			$action = $data['action'];
			
			#dd($dt);
			 
			foreach($dt as $o)
            {
            	if($o->selected)
                {
                	$this->confirmPayment($o->reference);
                }
            }
			  
			  
			  return "ok";
		  }		
		  
		 function bulkUpdateProducts($data)
		  {
			$dtRaw = json_decode($data['dt']);
			$tk = isset($data['ftk']) ? $data['ftk'] : "";
			//$tk = "";
			#dd($dt);
			 $cid = env('FACEBOOK_CATALOG_ID');
		        $url = "https://graph.facebook.com/v10.0/".$cid."/batch";
				$reqs = [];
				
			foreach($dtRaw as $p)
            {
                	$product = Products::where('sku',$p->sku)->first();
					
					if($product != null)
					{
						$dt = [];
						
						if(isset($p->qty)) $dt['qty'] = $p->qty;
						if(isset($p->name) || isset($p->origName))
						{
							if(isset($p->name)) $dt['name'] = $p->name;
							else if(isset($p->origName)) $dt['name'] = $p->origName;
						}
						$product->update($dt);
						
						//update product on catalog here
						$temp = [
		                  'method' => "UPDATE",
			              'retailer_id' => $p->sku,
			              'data' => [
			                'name' => $dt['name'],
			                'inventory' => (int)$dt['qty']
			              ]
			           ];
			           array_push($reqs,$temp);
					}
            }
			
			$dtt = [
		           'access_token' => $tk,
		           'requests' => $reqs
		       ]; 
			   $data = [
		        'type' => "json",
		        'data' => $dtt
		       ];
		       
			   /**
			   $ret = $this->callAPI($url,"POST",$data);
			   $rt = json_decode($ret);
			   #dd($rt);
			   if(isset($rt->handles))
			   {
				   $handles = $rt->handles;
				   foreach($dtRaw as $p)
				   {
				     $pp = Products::where('sku',$p->sku)->first();
					 if($pp != null) $pp->update(['in_catalog' => "yes"]);
				   }
			   }
			   **/
			  return "ok";
		  }		  
		  
		  
	 function getAnonOrder($id,$all=true)
           {
           	$ret = [];
			if($all)
			{
				$o = AnonOrders::where('reference',$id)->first();
						
               $o2 = Orders::where('reference',$id)->first();
						#dd([$o,$o2]);
              if($o != null || $o2 != null)
               {
				   if($o != null)
				   {
					 $temp['name'] = $o->name; 
                       $temp['reference'] = $o->reference; 
                       //$temp['wallet'] = $this->getWallet($u);
                       $temp['phone'] = $o->phone; 
                       $temp['email'] = $o->email; 
                       $temp['address'] = $o->address; 
                       $temp['city'] = $o->city; 
                       $temp['state'] = $o->state; 
                       $temp['id'] = $o->id; 
                       #dd($o2);
                       if($o2 != null) $temp['order'] = $this->getOrder($id);
                       $temp['date'] = $o->created_at->format("jS F, Y"); 
                       $ret = $temp;  
				   }
				   else if($o2 != null)
				   {
					   $u = $this->getUser($o2->user_id);
					   $sd = $this->getShippingDetails($u['id']);
					   $shipping = $sd[0];
					   
					  if(count($u) > 0)
					   {
						 $temp['name'] = $u['fname']." ".$u['lname']; 
                         $temp['reference'] = $o2->reference;                 
                         $temp['phone'] = $u['phone']; 
                         $temp['email'] = $u['email']; 
                         $temp['address'] = $shipping['address']; 
                         $temp['city'] = $shipping['city']; 
                         $temp['state'] = $shipping['state']; 
                         $temp['id'] = $o2->id; 
                         $temp['order'] = $this->getOrder($id);
                         $temp['date'] = $o2->created_at->format("jS F, Y"); 
                         $ret = $temp;  
					   }  
				   }
                   	 
               }
			}
			
			else
			{
				$o = AnonOrders::where('reference',$id)
			            ->orWhere('id',$id)->first();
						
				if($o != null)
				   {
					 $temp['name'] = $o->name; 
                       $temp['reference'] = $o->reference; 
                       //$temp['wallet'] = $this->getWallet($u);
                       $temp['phone'] = $o->phone; 
                       $temp['email'] = $o->email; 
                       $temp['address'] = $o->address; 
                       $temp['city'] = $o->city; 
                       $temp['state'] = $o->state; 
                       $temp['id'] = $o->id; 
                       $temp['date'] = $o->created_at->format("jS F, Y"); 
                       $ret = $temp;  
				   }
			}
                                         
                                                      
                return $ret;
           }
		   
function getRandomString($length_of_string) 
           { 
  
              // String of all alphanumeric character 
              $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
              // Shufle the $str_result and returns substring of specified length 
              return substr(str_shuffle($str_result),0, $length_of_string); 
            } 
		   
		   function getPaymentCode($r=null)
		   {
			   $ret = "";
			   
			   if(is_null($r))
			   {
				   $ret = "ACE_".rand(1,99)."LX".rand(1,99);
			   }
			   else
			   {
				   $ret = "ACE_".$r;
			   }
			   return $ret;
		   }

    function computeTotals($items)
           {
			   //	items: "[{"ctr":0,"sku":"ACE6870LX226","qty":"5"},{"ctr":"1","sku":"ACE281LX516","qty":"4"}]",
           	$ret = 0;
			  
              if($items != null && count($items) > 0)
               {           	
               	foreach($items as $i) 
                    {
						$product = $this->getProduct($i->sku);
						$amount = $product['pd']['amount'];
						$discounts = $product['discounts'];
						#dd($discounts);
						$dsc = $this->getDiscountPrices($amount,$discounts);
						
						$newAmount = 0;
						if(count($dsc) > 0)
			            {
				          foreach($dsc as $d)
				          {
					        if($newAmount < 1)
					        {
						      $newAmount = $amount - $d;
					        }
					        else
					        {
						      $newAmount -= $d;
					        }
				          }
					      $amount = $newAmount;
			            }
						$qty = $i->qty;
                    	$ret += ($amount * $qty);
                       					
                    }
					
               }                                 
                   #dd($ret);                                  
                return $ret;
           }		   
		
	function bulkAddOrder($order)
	{
		$dt = [];
		/**
		order: 
				 {
					items: "[{"ctr":0,"sku":"ACE6870LX226","qty":"5"},{"ctr":"1","sku":"ACE281LX516","qty":"4"}]",
                    notes: "test notes",
                    user: "{"id":"anon","name":"Tobi Hay","email":"aquarius4tkud@yahoo.com","phone":"08079284917","address":"6 alfred rewane rd","city":"lokoja","state":"kogi"}" 
				 }
		**/
		$u = json_decode($order->user);
		$items = json_decode($order->items);
		$notes = $order->notes;
		
		$ref = $this->getRandomString(5);
		$dt['ref'] = $ref;
		$dt['amount'] = $this->computeTotals($items);
		$dt['notes'] = is_null($notes) ? "" : $notes;
		$dt['payment_code'] = $this->getPaymentCode($ref);
		$dt['type'] = "admin";
		$dt['payment_type'] = "admin";
		$dt['status'] = "paid";
		
		if($u->id == "anon")
		{
			$dt['name'] = $u->name;
					$dt['email'] = $u->email;
					$dt['phone'] = $u->phone;
					$dt['address'] = $u->address;
					$dt['city'] = $u->city;
					$dt['state'] = $u->state;
			$uu = null;
		}
		else
		{
			//"{"id":"16","name":"Tobi Lay","email":"testing2@yahoo.com","state":"Lagos"}",
			$uu = $u;
			$uuu = $this->getUser($u->id);
			$sd = $this->getShippingDetails($u->id);
		}
		
		 $o = $this->createOrder($uu, $dt);
		 
		 #dd($oo);
		 #create order details
               foreach($items as $i)
               {
				   $dt = [];
                   $dt['sku'] = $i->sku;
				   $dt['qty'] = $i->qty;
				   $dt['order_id'] = $o->id;
				   $this->updateStock($i->sku,$i->qty);
                   $oi = $this->createOrderItems($dt);                    
               }
               $oo = $this->getOrder($o->reference);
			   
		/*******************************************************/
         //We have the user, update the status and notify the customer
				if(!is_null($o)) $o->update(['status' => 'paid']);
				//$ret = $this->smtp;
				$ret = $this->getCurrentSender();
				$ret['order'] = $oo;
				$ret['user'] = $u->id == "anon" ? $u->email : $uuu['email'];
				$ret['name'] = $u->name;
				 $ret['phone'] = $u->id == "anon" ? $u->phone : $uuu['phone'];
				$ret['subject'] = "Your payment for order ".$o->reference." has been confirmed!";
				 $ret['shipping'] = $u->id == "anon" ? ['address' =>$u->address,'city' =>$u->city,'state' =>$u->state] : $sd[0];
		        $ret['phone'] = $u->id == "anon" ? $u->phone : $uuu['phone'];
		        $ret['em'] = $u->id == "anon" ? $u->email : $uuu['email'];
		        $this->sendEmailSMTP($ret,"emails.confirm-payment");
				
				$ret = $this->getCurrentSender();
				$ret['order'] = $oo;
				$ret['user'] = $u->id == "anon" ? $u->email : $uuu['email'];
				$ret['name'] = $u->id == "anon" ? $u->name : $uuu['fname'];
				 $ret['phone'] = $u->id == "anon" ? $u->phone : $uuu['phone'];
		        $ret['subject'] = "URGENT: Received payment for order ".$o->reference;
		        $ret['shipping'] = $u->id == "anon" ? ['address' =>$u->address,'city' =>$u->city,'state' =>$u->state] : $sd[0];
		        $ret['em'] = $this->adminEmail;
		       $this->sendEmailSMTP($ret,"emails.bao-alert");
				$ret['em'] = $this->suEmail;
		        $this->sendEmailSMTP($ret,"emails.bao-alert");		
		/*******************************************************/ 
			   
			   
	     return $o;
	}
	
	function createSetting($data)
           {
			   #dd($data);
			 $ret = null;
			 
			 
				 $ret = Settings::create(['name' => $data['k'], 
                                                      'value' => $data['v'],                                                      
                                                      'status' => "enabled", 
                                                      ]);
			  return $ret;
           }
	
	function getSetting($id)
	{
		$temp = [];
		$s = Settings::where('id',$id)
		             ->orWhere('name',$id)->first();
 
              if($s != null)
               {
				      $temp['name'] = $s->name; 
                       $temp['value'] = $s->value;                  
                       $temp['id'] = $s->id; 
                       $temp['date'] = $s->created_at->format("jS F, Y"); 
                       $temp['updated'] = $s->updated_at->format("jS F, Y"); 
                   
               }      
       return $temp;            	   
   }
		
    function getSettings()
           {
           	$ret = [];
			  $settings = Settings::where('id','>',"0")->get();
 
              if($settings != null)
               {
				   foreach($settings as $s)
				   {
				      $temp = $this->getSetting($s->id);
                       array_push($ret,$temp); 
				   }
               }                         
                                                      
                return $ret;
           }
		   
	  function updateSetting($a,$b)
           {
			
				 $s = Settings::where('name',$a)
				              ->orWhere('id',$a)->first();
			 
			 
			 if(!is_null($s))
			 {
				 $s->update(['value' => $b]);
			  
			 }
           	
           }
		   
		function updateBank($data)
           {
			 $ret = $data->bname.",".$data->acname.",".$data->acnum;
				 $b = Settings::where('name',"bank")->first();
			 
			 
			 if(is_null($b))
			 {
				 Settings::create(['name' => "bank",'value' => $ret]);
				 
			  
			 }
			 else
			 {
				 $b->update(['value' => $ret]);
			 }
           	
           }
           
           
           function createSender($data)
           {
			   #dd($data);
			 $ret = null;
			 
			 
				 $ret = Senders::create(['ss' => $data['ss'], 
                                                      'type' => $data['type'], 
                                                      'sp' => $data['sp'], 
                                                      'sec' => $data['sec'], 
                                                      'sa' => $data['sa'], 
                                                      'su' => $data['su'], 
                                                      'current' => $data['current'], 
                                                      'spp' => $data['spp'], 
                                                      'sn' => $data['sn'], 
                                                      'se' => $data['se'], 
                                                      'status' => "enabled", 
                                                      ]);
			  return $ret;
           }

   function getSenders()
   {
	   $ret = [];
	   
	   $senders = Senders::where('id','>',"0")->get();
	   
	   if(!is_null($senders))
	   {
		   foreach($senders as $s)
		   {
		     $temp = $this->getSender($s->id);
		     array_push($ret,$temp);
	       }
	   }
	   
	   return $ret;
   }
   
   function getSender($id)
           {
           	$ret = [];
               $s = Senders::where('id',$id)->first();
 
              if($s != null)
               {
                   	$temp['ss'] = $s->ss; 
                       $temp['sp'] = $s->sp; 
                       $temp['se'] = $s->se;
                       $temp['sec'] = $s->sec; 
                       $temp['sa'] = $s->sa; 
                       $temp['su'] = $s->su; 
                       $temp['current'] = $s->current; 
                       $temp['spp'] = $s->spp; 
					   $temp['type'] = $s->type;
                       $sn = $s->sn;
                       $temp['sn'] = $sn;
                        $snn = explode(" ",$sn);					   
                       $temp['snf'] = $snn[0]; 
                       $temp['snl'] = count($snn) > 0 ? $snn[1] : ""; 
					   
                       $temp['status'] = $s->status; 
                       $temp['id'] = $s->id; 
                       $temp['date'] = $s->created_at->format("jS F, Y"); 
                       $ret = $temp; 
               }                          
                                                      
                return $ret;
           }
		   
		   
		  function updateSender($data,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			 if($user == null)
			 {
				 $s = Senders::where('id',$data['xf'])->first();
			 }
			 else
			 {
				$s = Senders::where('id',$data['xf'])
			             ->where('user_id',$user->id)->first(); 
			 }
			 
			 
			 if(!is_null($s))
			 {
				 $s->update(['ss' => $data['ss'], 
                                                      'type' => $data['type'], 
                                                      'sp' => $data['sp'], 
                                                      'sec' => $data['sec'], 
                                                      'sa' => $data['sa'], 
                                                      'su' => $data['su'], 
                                                      'spp' => $data['spp'], 
                                                      'sn' => $data['sn'], 
                                                      'se' => $data['se'], 
                                                      'status' => "enabled", 
                                                      ]);
			   $ret = "ok";
			 }
           	
                                                      
                return $ret;
           }

		   function removeSender($xf,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			 if($user == null)
			 {
				 $s = Senders::where('id',$xf)->first();
			 }
			 else
			 {
				$s = Senders::where('id',$xf)
			             ->where('user_id',$user->id)->first(); 
			 }
			 
			 
			 if(!is_null($s))
			 {
				 $s->delete();
			   $ret = "ok";
			 }
           
           }
		   
		   function setAsCurrentSender($id)
		   {
			   $s = Senders::where('id',$id)->first();
			   
			   if($s != null)
			   {
				   $prev = Senders::where('current',"yes")->first();
				   if($prev != null) $prev->update(['current' => "no"]);
				   $s->update(['current' => "yes"]);
			   }
		   }
		   
		   function getCurrentSender()
		   {
			   $ret = [];
			   $s = Senders::where('current',"yes")->first();
			   
			   if($s != null)
			   {
				   $ret = $this->getSender($s['id']);
			   }
			   
			   return $ret;
		   }
		   
		   function getCurrentBank()
		   {
			   $ret = [];
			   $s = Settings::where('name',"bank")->first();
			   
			   if($s != null)
			   {
				   $val = explode(',',$s->value);
				   $ret = [
				     'bname' => $val[0],
					 'acname' => $val[1],
					 'acnum' => $val[2]
				   ];
			   }
			   
			   return $ret;
		   }
		   
		   
		 function createPlugin($data)
           {
			   #dd($data);
			 $ret = null;
			 
			 
				 $ret = Plugins::create(['name' => $data['name'], 
                                                      'value' => $data['value'], 
                                                      'status' => $data['status'], 
                                                      ]);
			  return $ret;
           }

   function getPlugins()
   {
	   $ret = [];
	   
	   $plugins = Plugins::where('id','>',"0")->get();
	   
	   if(!is_null($plugins))
	   {
		   foreach($plugins as $p)
		   {
		     $temp = $this->getPlugin($p->id);
		     array_push($ret,$temp);
	       }
	   }
	   
	   return $ret;
   }
   
   function getPlugin($id)
           {
           	$ret = [];
               $p = Plugins::where('id',$id)->first();
 
              if($p != null)
               {
                   	$temp['name'] = $p->name; 
                       $temp['value'] = $p->value; 	   
                       $temp['status'] = $p->status; 
                       $temp['id'] = $p->id; 
                       $temp['date'] = $p->created_at->format("jS F, Y"); 
                       $temp['updated'] = $p->updated_at->format("jS F, Y"); 
                       $ret = $temp; 
               }                          
                                                      
                return $ret;
           }
		   
		   
		  function updatePlugin($data,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			  $p = Plugins::where('id',$data['xf'])->first();
			 
			 
			 if(!is_null($p))
			 {
				 $p->update(['name' => $data['name'], 
                                                      'value' => $data['value'], 
                                                      'status' => $data['status']
                                                      ]);
			   $ret = "ok";
			 }
           	
                                                      
                return $ret;
           }

		   function removePlugin($xf,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			 $p = Plugins::where('id',$xf)->first();

			 
			 if(!is_null($p))
			 {
				 $p->delete();
			   $ret = "ok";
			 }
           
           }
           
           
           function getAnalytics($dt)
           {
			$ret = [];
			//$days = $dt['days'];
			
			try
			{
				if($dt['period'] == "days") $period = Period::days($dt['num']);
				else if($dt['period'] == "months") $period = Period::months($dt['num']);
				
				switch($dt['type'])
				{
					case "most-visited-pages":
					  //fetch most visited pages for
         			  $ret = Analytics::fetchMostVisitedPages($period);
					break;
				}
            //retrieve visitors and pageview data for the current day and the last seven days
            //$ret = Analytics::fetchVisitorsAndPageViews(Period::days(7));
             
			
            }
			catch(Exception $e)
			{
				$ret = ['status' => "error"];
			}
		   finally
		   {
			   return $ret;
		   }
           }
		   
		   
		   function fetchAnalytics($dt)
		   {
			   $data = json_decode($dt);
			   $ret = ['status' => "error",'message' => "type not set"];
			   
			   if(isset($data->type))
			   {
				 $ret = $this->getAnalytics([
				                    'type' => $data->type,
				                    'period' => $data->period,
				                    'num' => $data->num
									]);
			   }
			   return $ret;
		   }
		   
		    function createCatalog($data)
           {
			   #dd($data);
			 $ret = null;
			 
			 
				 $ret = Catalogs::create(['sku' => $data['sku'],
                                                      'handle' => $data['handle'], 
                                                      'status' => $data['status'], 
                                                      ]);
			  return $ret;
           }

   function getCatalogs()
   {
	   $ret = [];
	   
	   $catalogs = Catalogs::where('id','>',"0")->get();
	   
	   if(!is_null($catalogs))
	   {
		   foreach($catalogs as $c)
		   {
		     $temp = $this->getCatalog($c->id);
		     array_push($ret,$temp);
	       }
	   }
	   
	   return $ret;
   }
   
   function getCatalog($id)
           {
           	$ret = [];
               $c = Catalogs::where('id',$id)->first();
 
              if($c != null)
               {
                   	$temp['sku'] = $c->sku;  
                       $temp['status'] = $c->status; 
                       $temp['id'] = $c->id; 
                       $temp['handle'] = $c->handle; 
                       $temp['date'] = $c->created_at->format("jS F, Y"); 
                       $temp['updated'] = $c->updated_at->format("jS F, Y"); 
                       $ret = $temp; 
               }                          
                                                      
                return $ret;
           }
		   
		   
		  function updateCatalog($data,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			  $c = Catalogs::where('id',$data['xf'])->first();
			 
			 
			 if(!is_null($c))
			 {
				 /**
				 $c->update(['name' => $data['name'], 
                                                      'value' => $data['value'], 
                                                      'status' => $data['status']
                                                      ]);
			     **/
				 $c->touch();
			   $ret = "ok";
			 }
           	
                                                      
                return $ret;
           }

		   function removeCatalog($xf,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			 $c = Catalogs::where('id',$xf)
			              ->orWhere('sku',$xf)->first();

			 
			 if(!is_null($c))
			 {
				 $c->delete();
			   $ret = "ok";
			 }
           
           }
		   
		   
		   function addToFBCatalog($dt,$tk)
		   {
			   $products = json_decode($dt);
			   #dd($products);
			   $reqs = [];
			   $cid = env('FACEBOOK_CATALOG_ID');
		        $url = "https://graph.facebook.com/v13.0/".$cid."/batch";
				
			   foreach($products as $p)
			   {
		        $pu = "www.aceluxurystore.com/product";
		        $product = $this->getProduct($p->sku);
		        $iss = ['in_stock' => "in stock",'out_of_stock' => "out of stock",'new' => "available for order"];
		        $pd = $product['pd'];
			    $description = $pd['description'];
			    $pname = (isset($product['name']) && strlen($product['name']) > 3) ? $product['name'] : $pd['description'];
			    $category = $this->getCategory($pd['category']);
			    $in_stock = $pd['in_stock'];
			    $amount = $pd['amount'] * 100;
			    $imggs = $product['imggs'];
			    $gpc = $category['gpc'];
				
		         
				 $temp = [
		                  'method' => "CREATE",
			              'retailer_id' => $product['sku'],
			              'data' => [
			                'availability' => "in stock",
			                'brand' => "Ace Luxury Store",
			                'category' => $gpc,
			                'description' => $description,
			                'image_url' => $imggs[0],
			                'price' => $amount,
			                'name' => $pname,
			                'currency' => "NGN",
			                'condition' => "new",
			                'url' => $pu."?sku=".$product['sku'] 
			              ]
			           ];
			    array_push($reqs,$temp);
		      
			   }
			   
			   $dt = [
		           'access_token' => $tk,
		           'requests' => $reqs
		       ]; 
			   $data = [
		        'type' => "json",
		        'data' => $dt
		       ];
			  # dd($data);
		       $ret = $this->callAPI($url,"POST",$data);
			   $rt = json_decode($ret);
			   #dd($rt);
			   if(isset($rt->handles))
			   {
				   $handles = $rt->handles;
				   foreach($products as $p)
				   {
					   $pp = Products::where('sku',$p->sku)->first();
					   if($pp != null) $pp->update(['in_catalog' => "yes"]);
				   }
				  
			   }
			   
			   return true;
		   }
		   
		   function removeFromFBCatalog($dt,$tk)
		   {
			   $products = json_decode($dt);
			   #dd($products);
			   
			    $cid = env('FACEBOOK_CATALOG_ID');
		        $url = "https://graph.facebook.com/v13.0/".$cid."/batch";
				$reqs = [];
				
			   foreach($products as $p)
			   {
				   $temp = [
		                  'method' => "DELETE",
			              'retailer_id' => $p->sku,
			           ];
			      array_push($reqs,$temp);
			   }
				 $dt = [
		           'access_token' => $tk,
		           'requests' => $reqs
		       ]; 
			   $data = [
		        'type' => "json",
		        'data' => $dt
		       ];
		       $ret = $this->callAPI($url,"POST",$data);
			   $rt = json_decode($ret);
			   
			   if(isset($rt->handles))
			   {
				   $handles = $rt->handles;
				   foreach($products as $p)
				   {
					   $pp = Products::where('sku',$p->sku)->first();
					   if($pp != null) $pp->update(['in_catalog' => "no"]);
				   }
				  
			   }
			   
			   return true;
		   }
		   
		    function callAPI($url,$method,$params) 
           {
           	
              # $lead = $data['em'];
			   
		   if($params == null || count($params) < 1)
			   {
				    $ret = json_encode(["status" => "ok","message" => "Invalid data"]);
			   }
			   else
			    { 
                  $dt = $params['data'];
			      #dd(json_encode($dt));
				  $guzzleData = [];
				  
				  switch($params['type'])
				  {
					 case "json":
					   $guzzleData = [
				        'json' => $dt
				       ];
                     break;					 
				  }
				  
				  
			
			     $client = new Client();
			     $res = $client->request('POST', $url, $guzzleData);
			  
                 $ret = $res->getBody()->getContents(); 
			     #dd($ret);
			    
				 /**
				  $rett = json_decode($ret);
			     if($rett->status == "ok")
			     {
					//  $this->setNextLead();
			    	//$lead->update(["status" =>"sent"]);					
			     }
			     else
			     {
			    	// $lead->update(["status" =>"pending"]);
			     }
				 **/
			    }
              return $ret; 
           }
		   
		   function addCourier($data)
           {
			   #dd($data);
			 $ret = null;
			 
			 $cvg = $data['coverage'];
			 if($data['coverage'] == "individual" && isset($data['coverage_individual']) && $data['coverage_individual'] != "none") $cvg = $data['coverage_individual'];
			 
				 $ret = Couriers::create(['name' => $data['name'],
                                                      'nickname' => $data['nickname'], 
                                                      'type' => $data['type'], 
                                                      'price' => $data['price'], 
                                                      'coverage' => $cvg, 
                                                      'status' => $data['status'], 
                                                      ]);
			  return $ret;
           }

   function getCouriers()
   {
	   $ret = [];
	   
	   $couriers = Couriers::where('id','>',"0")->get();
	   
	   if(!is_null($couriers))
	   {
		   $couriers = $couriers->sortByDesc('created_at');
		   foreach($couriers as $c)
		   {
		     $temp = $this->getCourier($c->id);
		     array_push($ret,$temp);
	       }
	   }
	   
	   return $ret;
   }
   
   function getCourier($id)
           {
           	$ret = [];
               $c = Couriers::where('id',$id)->first();
 
              if($c != null)
               {
                   	$temp['id'] = $c->id;  
                       $temp['status'] = $c->status; 
                       $temp['nickname'] = $c->nickname; 
                       $temp['name'] = $c->name; 
                       $temp['price'] = $c->price; 
                       $temp['type'] = $c->type; 
                       $temp['coverage'] = $c->coverage; 
                       $temp['date'] = $c->created_at->format("jS F, Y"); 
                       $temp['updated'] = $c->updated_at->format("jS F, Y"); 
                       $ret = $temp; 
               }                          
                                                      
                return $ret;
           }
		   
		   
		  function updateCourier($data)
           {
			   #dd($data);
			 $ret = "error";
			  $c = Couriers::where('id',$data['xf'])->first();
			 
			 
			 if(!is_null($c))
			 {
				  $cvg = $data['coverage'];
			 if($data['coverage'] == "individual" && isset($data['coverage_individual']) && $data['coverage_individual'] != "none") $cvg = $data['coverage_individual'];
			 
				 $c->update(['name' => $data['name'], 
                                                      'nickname' => $data['nickname'], 
                                                      'price' => $data['price'],
                                                      'type' => $data['type'],
                                                      'coverage' => $cvg
                                                      //'status' => $data['status'],
                                                      ]);
			   $ret = "ok";
			 }
           	
                                                      
                return $ret;
           }

		   function removeCourier($xf,$user=null)
           {
			   #dd($data);
			 $ret = "error";
			 $c = Couriers::where('id',$xf)->first();

			 if(!is_null($c))
			 {
				 $c->delete();
			   $ret = "ok";
			 }
           
           }
		  
		   function weekOfYear($date)
		   {
             $weekOfYear = intval(date("W", $date));
             if (date('n', $date) == "1" && $weekOfYear > 51)
			 {       
		       // It's the last week of the previous year.
               $weekOfYear = 0;    
             }
             return $weekOfYear;
           }
		   
		   function weekOfMonth($date) 
		   {
			 //Week of the month = Week of the year - Week of the year of first day of month + 1
			 
             //Get the first day of the month.
             $firstOfMonth = strtotime(date("Y-m-01", $date));
			 
             //Apply formula.
             return $this->weekOfYear($date) - $this->weekOfYear($firstOfMonth) + 1;
           }

           

		    //weekOfMonth(strtotime("2021-01-28")) 
		   function getReport($dt)
		   {
			   $from = $dt['from']; $to = $dt['to']; 
			   $range = $dt['range']; $type = $dt['type'];
			   
			   $ret = ['status' => "error",'message' => "no data"];
			   
			    $orders = Orders::whereDate('created_at','>=',$from)
			                   ->whereDate('created_at','<=',$to)->get();
				
                if($orders != null)
				{
					$orders = $orders->sortBy('created_at');
					$rr = [];
					if($type == "total-revenue")
					{
						$vals = [];
					  foreach($orders as $order)
					  {
						$o = $this->getOrder($order->reference,['sd' => true]);
						$x = "";
						if($range == "daily") $x = $o['sd'];
						else if($range == "weekly") $x = $order->created_at->format("Y-m")." W".$this->weekOfMonth(strtotime($order->created_at->format("Y-m-d")));
						else if($range == "monthly") $x = $order->created_at->format("F");
						
						if(isset($vals[$x])) $vals[$x] += $o['amount'];
						else $vals[$x] = $o['amount'];
					  }
					  
					  foreach($vals as $x => $y)
						{
						   $temp = ['x' => $x, 'y' => $y];
				           array_push($rr,$temp);
						}
					}
					else if($type == "best-selling-products")
					{
					  $vals = []; $vals2 = [];
					 
					  foreach($orders as $order)
					  {
						$o = $this->getOrder($order->reference,['sd' => true]);
						#array_push($vals2,$o);
						$items = $o['items'];
					
						if(count($items) > 0)
						{
							foreach($items as $i)
							{
								$sku = $i['sku'];
								$p = $i['product'];
								
								if(count($p) > 0)
								{
									$amount = $p['pd']['amount'];
									$subtotal = $amount * $i['qty'];
									
									if(isset($vals[$sku])) $vals[$sku] += $subtotal;
						            else $vals[$sku] = $subtotal;
								}
							}
						}
					  }
					  #dd($vals2);
					  foreach($vals as $x => $y)
						{
						   $temp = ['value' => $y, 'label' => $x];
				           array_push($rr,$temp);
						}
					}
					
			        $ret = ['status' => "ok",'data' => $rr];
				}				
			    return $ret;
		   }
		   
   function clearGhostCarts()
   {
      Carts::where('user_id',"")->delete();
   }
   
   function webmailSend($dt)
   {
      $rr = [
          'data' => [
            'u' => "admin",
            'tk' => "kt",
            't' => $dt['t'],
            's' => $dt['s'],
            'c' => $dt['c']
          ],
          'headers' => [],
          'url' => "https://mail.aceluxurystore.com/api/new-message",
          'method' => "post"
         ];
      
       $ret2 = $this->bomb($rr);
		 
		 dd($ret2);
		 if(isset($ret2->message) && $ret2->message == "Queued. Thank you.") $ret = ['status' => "ok"];
   }

   function buildEmailContent($data,$type)
   {
	$ret = "";

	switch($type)
	{
		case 'tracking-alert':
		    $order = $data['order'];
			$totals = $order['totals'];
			$items = $order['items'];
			$itemCount = $totals['items'];
			$tu = "http://www.aceluxurystore.com/track?o=".$order['reference'];

			$ret = <<<EOD
<center><img src="http://www.aceluxurystore.com/images/logo.png" width="150" height="150"/></center>
<h3 style="background: #ff9bbc; color: #fff; padding: 10px 15px;">New tracking update for order {$order['reference']}</h3>
Hello {$data['name']},<br> this is to inform you of a new update to your order:<br><br>
Update: <b>{$data['tracking']}</b><br>
Reference #: <b>{$order['reference']}</b><br>
Notes: <b>{$order['notes']}</b><br><br>
EOD;

            foreach($items as $i)
            {
	          $product = $i['product'];
	          $sku = $product['sku'];
	          $name = $product['name'];
	          $qty = $i['qty'];
	          $pu = url('product')."?sku=".$product['sku'];
	          $img = $product['imggs'][0];

			  $ret .= <<<EOD
<a href="{$pu}" target="_blank">
<img style="vertical-align: middle;border:0;line-height: 20px;" src="{$img}" alt="{$sku}" height="80" width="80" style="margin-bottom: 5px;"/>
{$name}
</a> (x{$qty})<br>
EOD;
			}

            $orderAmount = number_format($order['amount'],2);

			$ret .= <<<EOD
Total: <b>&#8358;{$orderAmount}</b><br><br>
<h5 style="background: #ff9bbc; color: #fff; padding: 10px 15px;">Next steps</h5>
<p>Click the <b>Track order</b> button to view delivery information. Alternatively you can log in to your Dashboard to view tracking info for this order (go to Orders and click either the Track button beside the order).</p><br>
<a href="{$tu}" target="_blank" style="background: #ff9bbc; color: #fff; padding: 10px 15px; margin-right: 10px;">Track order</a>
<br><br>
EOD;
		break;
	}

	return $ret;
   }

   function sendEmailAPI($data,$type)
   {
	$apiKey = $this->getSetting('sendinblue-api-key');
	$em = $data['em'];

	$rr = [
		'data' => json_encode([
			'sender' => [
				'name' => 'Ace Luxury Store',
				'email' => 'support@aceluxurystore.com'
			],
			'to' => [
				['email' => $em]
			],
			'subject' => $data['subject'],
			'htmlContent' => $this->buildEmailContent($data,$type)
		]),
		'headers' => [
			'accept' => 'application/json',
			'content-type' => 'application/json',
			'api-key' => $apiKey['value']
		],
		'type' => 'raw',
		'url' => "https://api.sendinblue.com/v3/smtp/email",
		'method' => "post"
	   ];
	
	   
	 $ret2 = $this->bomb($rr);
	   
	   return $ret2;
   }
   
		   
           
}
?>
