<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
  * file_cache
  *
  * This is a config file for the file_cache_helper for the
  * Codeigniter Framework. Make sure you read and configure
  * this file properly.
  *
  * @author     Matthew Craig <matt@taggedzi.com> 
  * @copyright  Matthew Craig 2011-03-28
  * @version    1.0
  * @link       http://taggedzi.com/ 
  * @package    file_cache_helper 
  */

/**

Copyright (c) 2011, Matthew Craig
All rights reserved.

Permitted Use

You are permitted to use, copy, modify, and distribute the Software and its 
documentation, with or without modification, for any purpose, provided that 
the following conditions are met:

1. A copy of this license agreement must be included with the distribution.
2. Redistributions of source code must retain the above copyright notice in 
all source code files.
3. Redistributions in binary form must reproduce the above copyright notice 
in the documentation and/or other materials provided with the distribution.
4. Any files that have been modified must carry notices stating the nature of 
the change and the names of those who changed them.
5. Products derived from the Software must include an acknowledgment that they 
are derived from this code in their documentation and/or other materials 
provided with the distribution.

Indemnity

You agree to indemnify and hold harmless the authors of the Software and any 
contributors for any direct, indirect, incidental, or consequential 
third-party claims, actions or suits, as well as any related expenses, 
liabilities, damages, settlements or fees arising from your use or misuse of 
the Software, or a violation of any terms of this license.

Disclaimer of Warranty

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESSED OR 
IMPLIED, INCLUDING, BUT NOT LIMITED TO, WARRANTIES OF QUALITY, PERFORMANCE, 
NON-INFRINGEMENT, MERCHANTABILITY, OR FITNESS FOR A PARTICULAR PURPOSE.

Limitations of Liability

YOU ASSUME ALL RISK ASSOCIATED WITH THE INSTALLATION AND USE OF THE SOFTWARE. 
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS OF THE SOFTWARE BE LIABLE 
FOR CLAIMS, DAMAGES OR OTHER LIABILITY ARISING FROM, OUT OF, OR IN CONNECTION 
WITH THE SOFTWARE. LICENSE HOLDERS ARE SOLELY RESPONSIBLE FOR DETERMINING THE 
APPROPRIATENESS OF USE AND ASSUME ALL RISKS ASSOCIATED WITH ITS USE, INCLUDING 
BUT NOT LIMITED TO THE RISKS OF PROGRAM ERRORS, DAMAGE TO EQUIPMENT, LOSS OF 
DATA OR SOFTWARE PROGRAMS, OR UNAVAILABILITY OR INTERRUPTION OF OPERATIONS.

*/


/**
 * file_cache_path
 * 
 * This is the PATH used to store the cache data.
 * This can be a relative or absolute path.  (relative paths are computed 
 * in relation to the "/index.php" in your website root.)
 * Care should be taken when selecting.  The cache data 
 * is not encrypted or secured in anyway by this software.
 * Do not cache sensitive data in a path that is 
 * publicly visible.
 *
 * This MUST have a trailing slash.
 */
$config['file_cache_path'] = './cache/';

/**
 *  prefix
 *
 * This is the prefix to use for the actual cache file
 * this is used to help prevent collisions when multiple
 * sites are sharing the same cache folder.
 * It is strongly recommended that this be used.
 * This is a STRING and must be of file type appropriate
 * characters. 
 */
$config['prefix']          = 'fc';  // Default "fc" for "file_cache".


/**
 *  delimiter
 *
 *  This is the delimiter used to separate the prefix from the key.
 *  I strongly recommend using the _ character. 
 *  Do not change this unless you know what you are doing and have 
 *  a good reason to do so.
 *  This CANNOT BE BLANK! 
 *  THIS CANNOT BE A LETTER OR NUMBER AND MUST NOT SHOW UP IN THE EXTENSION.
 */
$config['delimiter']       = '_';



/**
 *  file_extension 
 *  
 *  This is the extension to add to the cache file.
 *  You may use any extension you like, just be aware of your
 *  operating system limitations for file names.
 *
 *  NOTE: Do not include the "." this is automatically added. 
 */
$config['file_extension']  = 'cache';


/**
 *  encrypt_cache
 *
 *  Boolean. (TRUE = Encryption ON; FALSE = Encryption OFF)
 *  This var is used to determine IF encryption should be used.
 *  Be aware that Encryption does cause a performance hit AND
 *  A file size it as well.  All data is serialized THEN encrypted
 *  so data can become quite large depending on the data in question.
 *  This depends on the encryption KEY being set in the 
 *  application/config/config.php file. (This uses CI's encryption
 *  library, so your CI configurations are used. Please see CI's
 *  documentation for more details.
 *  If you do not have encryption configured (or mcrypt on your server
 *  it will use CI's default encryption.
 *  In general this should only be used on servers with no other options
 *  this is not an optimal choice for data caching.  But will do 
 *  when no other options are available.
 *
 */
$config['encrypt_cache']    = FALSE;

/* End of file file_cache.php */
/* Location: ./application/config/file_cache.php */
