<?php
// Initialize default variables
$message_base = "Message Here";
$action = "";
$emaillist = "your_email@yahoo.com";
$ssl_port = "587";
$my_smtp = "";
$nrotat = "0";
$reconnect = "0";
$isbcc = "";
$nbcc = "50";
$pause = "0";
$pemails = "0";
$from_base = "";
$realname_base = "Support";
$lase = true;
$replyto = "";
$repaslog = true;
$reading = false;
$epriority = "";
$subject_base = "Subject Here";
$encodety = "no";

// Include backend code only when sending
$output = '';
if(!empty($_POST['action']) && $_POST['action'] == 'send') {
    // Capture output for display in result section
    ob_start();
    include 'backend.php';
    $output = ob_get_clean();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Mailer</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .header {
            background: #fff;
            padding: 15px 20px;
            border-bottom: 1px solid #dee2e6;
        }

        .header h3 {
            color: #007bff;
            font-size: 16px;
            font-weight: 500;
            margin: 0;
        }

        .content {
            padding: 20px;
        }

        .section {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #495057;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 13px;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }

        .form-control:disabled {
            background: #e9ecef;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .checkbox-inline {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-right: 15px;
        }

        .checkbox-inline input {
            margin: 0;
        }

        .checkbox-inline label {
            margin: 0;
            font-weight: normal;
            cursor: pointer;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-danger:disabled {
            background: #f8d7da;
            color: #721c24;
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
        }

        .smtp-list {
            background: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
            min-height: 80px;
            max-height: 150px;
            overflow-y: auto;
            font-family: monospace;
            font-size: 12px;
            white-space: pre-wrap;
            color: #495057;
        }

        .inline-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .inline-group input[type="text"],
        .inline-group select {
            width: auto;
        }

        .inline-group span {
            font-size: 13px;
            color: #6c757d;
        }

        .result-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            min-height: 200px;
            max-height: 400px;
            overflow-y: auto;
            font-family: monospace;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .two-column {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" style="cursor: pointer;" onclick="toggleInstruction()">
            <h3 style="color: #007bff;">Instruction</h3>
        </div>
        
        <!-- INSTRUCTION PANEL -->
        <div id="instructionPanel" style="display: none; padding: 20px; background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
            <div style="margin-bottom: 15px;">
                <strong>How to use:</strong> <a href="#" style="color: #007bff;">Tutorial</a>
            </div>
            
            <ul style="list-style: none; padding-left: 0; font-size: 13px; color: #495057;">
                <li style="margin-bottom: 8px;">
                    <strong>[-email-]</strong> : Receiver Email (emailuser@emaildomain.com)
                    <ul style="margin-left: 20px; margin-top: 5px;">
                        <li><strong>[-emailuser-]</strong> : Email User (emailuser)</li>
                        <li><strong>[-emaildomain-]</strong> : Email User (emaildomain.com)</li>
                    </ul>
                </li>
                <li style="margin-bottom: 8px;"><strong>[-time-]</strong> : Date and Time (03/04/2021 02:41:23 pm)</li>
                <li style="margin-bottom: 8px;"><strong>[-randomstring-]</strong> : Random string (0-9,a-z)</li>
                <li style="margin-bottom: 8px;"><strong>[-randomnumber-]</strong> : Random number (0-9)</li>
                <li style="margin-bottom: 8px;"><strong>[-randomletters-]</strong> : Random Letters(a-z)</li>
                <li style="margin-bottom: 8px;"><strong>[-randommd5-]</strong> : Random MD5</li>
            </ul>
            
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                <strong style="display: block; margin-bottom: 8px;">example</strong>
                <div style="font-size: 13px; color: #495057;">
                    <p style="margin-bottom: 8px;">Receiver Email = <strong>user@domain.com</strong></p>
                    <ul style="list-style: disc; padding-left: 20px;">
                        <li>hello <strong>[-emailuser-]</strong> = hello <strong>user</strong></li>
                        <li>your domain is <strong>[-emaildomain-]</strong> = Your Domain is <strong>domain.com</strong></li>
                        <li>your code is <strong>[-randommd5-]</strong> = your code is <strong>e10adc3949ba59abbe56e057f20f883e</strong></li>
                    </ul>
                </div>
            </div>
            
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                <strong style="display: block; margin-bottom: 8px;">Generateur</strong>
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <div class="checkbox-inline">
                        <input type="checkbox" id="gen_az">
                        <label for="gen_az">(a-z)</label>
                    </div>
                    <div class="checkbox-inline">
                        <input type="checkbox" id="gen_AZ">
                        <label for="gen_AZ">(A-Z)</label>
                    </div>
                    <div class="checkbox-inline">
                        <input type="checkbox" id="gen_09">
                        <label for="gen_09">(0-9)</label>
                    </div>
                    <input type="text" id="gen_length" class="form-control" placeholder="Length" style="width: 80px;">
                    <input type="text" id="gen_pattern" class="form-control" placeholder="Pattern" style="width: 200px;" readonly>
                    <button type="button" class="btn btn-primary" id="getPattern">Get Pattern</button>
                </div>
                <p style="font-size: 12px; color: #6c757d; margin-top: 8px;">You can use the the generated pattern in your message.</p>
            </div>
        </div>
        
        <div class="content">
            <form method="post" action="" enctype="multipart/form-data">
                
                <!-- SERVER SETUP -->
                <div class="section">
                    <div class="section-title">Server Setup</div>
                    
                    <div class="two-column">
                        <!-- Left Column -->
                        <div>
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">SMTP Host</label>
                                    <input type="text" id="ip" name="ip" class="form-control" placeholder="SMTP Host">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Username</label>
                                    <input type="text" id="user" name="user" class="form-control" placeholder="SMTP Username">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Password</label>
                                    <input type="password" id="pass" name="pass" class="form-control" placeholder="SMTP Password">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Port</label>
                                    <input type="text" name="ssl_port" id="ssl_port" value="<?php echo $ssl_port;?>" class="form-control" placeholder="587">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Security</label>
                                    <div>
                                        <div class="checkbox-inline">
                                            <input type="radio" name="SSLTLS" value="TLS" id="tls">
                                            <label for="tls">TLS</label>
                                        </div>
                                        <div class="checkbox-inline">
                                            <input type="radio" name="SSLTLS" value="SSL" id="ssl">
                                            <label for="ssl">SSL</label>
                                        </div>
                                        <div class="checkbox-inline">
                                            <input type="radio" name="SSLTLS" value="NON" id="non">
                                            <label for="non">None</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Is bcc</label>
                                    <div class="checkbox-inline">
                                        <input type="checkbox" name="isbcc" value="true" id="isbcc" <?php if($isbcc=="true") echo "checked"; ?>>
                                        <label for="isbcc">Yes</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="add">Add SMTP</button>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div>
                            <div class="form-group">
                                <label>SMTP list</label>
                                <div style="background: #f8f9fa; border: 1px solid #ced4da; border-radius: 4px 4px 0 0; padding: 8px 10px; font-size: 11px; color: #6c757d; font-weight: 500;">
                                    SMTP Host | Port | Username | Password | Security | IsBcc
                                </div>
                                <textarea name="my_smtp" id="my_smtp" class="form-control" style="border-radius: 0 0 4px 4px; border-top: none; min-height: 100px; max-height: 150px; font-family: monospace; font-size: 12px; resize: vertical;"><?php echo $my_smtp;?></textarea>
                                <div style="margin-top: 5px; display: flex; gap: 8px; align-items: center;">
                                    <button type="button" class="btn btn-info" id="reset">Reset</button>
                                    <button type="button" class="btn btn-info" id="countSmtp" style="font-size: 12px; padding: 4px 8px;">
                                        <span id="smtpCount">0</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="inline-group">
                                    <label style="min-width: 140px;">Change SMTP every</label>
                                    <input name="nrotat" type="text" value="<?php echo $nrotat;?>" class="form-control">
                                    <span>Email</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="inline-group">
                                    <label style="min-width: 140px;">Pause</label>
                                    <input type="text" name="pause" value="<?php echo $pause;?>" class="form-control">
                                    <span>Seconds every</span>
                                    <input type="text" name="pemails" value="<?php echo $pemails;?>" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Email (1 bcc = 1 email)</label>
                            </div>
                            
                            <div class="form-group">
                                <div class="inline-group">
                                    <label style="min-width: 140px;">Reconnect after</label>
                                    <input type="text" name="reconnect" value="<?php echo $reconnect;?>" class="form-control">
                                    <span>Emails</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="inline-group">
                                    <label style="min-width: 140px;">Num of emails in bcc</label>
                                    <input type="text" name="nbcc" value="<?php echo $nbcc;?>" class="form-control">
                                    <span>Emails</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MESSAGE SETUP -->
                <div class="section">
                    <div class="section-title">Message Setup</div>
                    
                    <div class="two-column">
                        <!-- Left Column -->
                        <div>
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Sender email</label>
                                    <input type="text" name="from" id="from" value="<?php if(!$lase) echo $from_base;?>" class="form-control" placeholder="Sender email" <?php if($lase) echo "disabled"?> style="width: 250px;">
                                    <div class="checkbox-inline">
                                        <input type="checkbox" name="lase" value="true" id="lase" <?php if($lase) echo "checked"; ?> checked>
                                        <label for="lase">Sender email as login</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Reply-To</label>
                                    <input type="text" name="replyto" id="replyto" value="<?php if(!$repaslog) echo $replyto;?>" class="form-control" placeholder="Reply-To Email" <?php if($repaslog) echo "disabled";?> style="width: 250px;">
                                    <div class="checkbox-inline">
                                        <input type="checkbox" name="repaslog" value="true" id="repaslog" <?php if($repaslog) echo "checked"; ?> checked>
                                        <label for="repaslog">Reply-To as login</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Subject</label>
                                    <input type="text" name="subject" id="subject" value="<?php echo $subject_base;?>" class="form-control" placeholder="Subject Here" style="width: 250px;">
                                    <div class="checkbox-inline">
                                        <input type="checkbox" name="readingconf" value="true" id="readingconf" <?php if($reading) echo "checked"; ?>>
                                        <label for="readingconf">Debug Mode</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="message" id="message" class="form-control" placeholder="Message Here"><?php echo $message_base;?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-inline">
                                    <input type="radio" name="contenttype" value="plain" id="plain">
                                    <label for="plain">Text</label>
                                </div>
                                <div class="checkbox-inline">
                                    <input type="radio" name="contenttype" value="html" id="html" checked>
                                    <label for="html">Html</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="sendBtn">Send message</button>
                                <button type="button" class="btn btn-danger" id="stopBtn" style="display: none; margin-left: 10px;">Stop Sending</button>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div>
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Sender name</label>
                                    <input type="text" name="realname" id="realname" value="<?php echo $realname_base;?>" class="form-control" placeholder="Support">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Priority</label>
                                    <select name="epriority" id="epriority" class="form-control">
                                        <option value="" <?php if(strlen($epriority)< 1){print "selected";} ?>>NO PRIORITY</option>
                                        <option value="1" <?php if($epriority == "1"){print "selected";} ?>>High</option>
                                        <option value="3" <?php if($epriority == "3"){print "selected";} ?>>Normal</option>
                                        <option value="5" <?php if($epriority == "5"){print "selected";} ?>>Low</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px; line-height: 1.2;">Encoding /<br>Charset</label>
                                    <div style="display: flex; gap: 10px; flex: 1;">
                                        <select name="encodety" id="encodety" class="form-control">
                                            <option value="no" <?php if($encodety == "no"){print "selected";} ?>>NO</option>
                                            <option value="8bit" <?php if($encodety == "8bit"){print "selected";} ?>>8bit</option>
                                            <option value="7bit" <?php if($encodety == "7bit"){print "selected";} ?>>7bit</option>
                                            <option value="binary" <?php if($encodety == "binary"){print "selected";} ?>>Binary</option>
                                            <option value="base64" <?php if($encodety == "base64"){print "selected";} ?>>Base64</option>
                                            <option value="quoted-printable" <?php if($encodety == "quoted-printable"){print "selected";} ?>>Quoted-Printable</option>
                                        </select>
                                        <select name="charset" class="form-control">
                                            <option value="">NO CHARSET</option>
                                            <option value="utf-8">Unicode -> utf-8</option>
                                            <option value="utf-7">Unicode -> utf-7</option>
                                            <option value="us-ascii">Unicode -> us-ascii</option>
                                            <option value="iso-10646-ucs-2">Unicode -> iso-10646-ucs-2</option>
                                            <option value="iso-8859-6">Arabic -> iso-8859-6</option>
                                            <option value="x-mac-arabic">Arabic -> x-mac-arabic</option>
                                            <option value="windows-1256">Arabic -> windows-1256</option>
                                            <option value="iso-8859-4">Baltic -> iso-8859-4</option>
                                            <option value="windows-1257">Baltic -> windows-1257</option>
                                            <option value="iso-8859-2">Central European -> iso-8859-2</option>
                                            <option value="x-mac-ce">Central European -> x-mac-ce</option>
                                            <option value="windows-1250">Central European -> windows-1250</option>
                                            <option value="euc-cn">Chinese -> euc-cn</option>
                                            <option value="gb2312">Chinese -> gb2312</option>
                                            <option value="hz-gb-2312">Chinese -> hz-gb-2312</option>
                                            <option value="x-mac-chinesesimp">Chinese -> x-mac-chinesesimp</option>
                                            <option value="cp-936">Chinese -> cp-936</option>
                                            <option value="big5">Chinese -> big5</option>
                                            <option value="x-mac-chinesetrad">Chinese -> x-mac-chinesetrad</option>
                                            <option value="cp-950">Chinese -> cp-950</option>
                                            <option value="cp-932">Chinese -> cp-932</option>
                                            <option value="euc-tw">Chinese -> euc-tw</option>
                                            <option value="x-chinese-cns">Chinese -> x-chinese-cns</option>
                                            <option value="x-chinese-eten">Chinese -> x-chinese-eten</option>
                                            <option value="iso-8859-5">Cyrillic -> iso-8859-5</option>
                                            <option value="koi8-r">Cyrillic -> koi8-r</option>
                                            <option value="windows-1251">Cyrillic -> windows-1251</option>
                                            <option value="x-mac-cyrillic">Cyrillic -> x-mac-cyrillic</option>
                                            <option value="iso-8859-7">Greek -> iso-8859-7</option>
                                            <option value="windows-1253">Greek -> windows-1253</option>
                                            <option value="x-mac-greek">Greek -> x-mac-greek</option>
                                            <option value="iso-8859-8">Hebrew -> iso-8859-8</option>
                                            <option value="windows-1255">Hebrew -> windows-1255</option>
                                            <option value="euc-jp">Japanese -> euc-jp</option>
                                            <option value="shift_jis">Japanese -> shift_jis</option>
                                            <option value="iso-2022-jp">Japanese -> iso-2022-jp</option>
                                            <option value="euc-kr">Korean -> euc-kr</option>
                                            <option value="iso-2022-kr">Korean -> iso-2022-kr</option>
                                            <option value="iso-8859-10">Nordic -> iso-8859-10</option>
                                            <option value="iso-8859-3">South European -> iso-8859-3</option>
                                            <option value="iso-8859-15">Western European -> iso-8859-15</option>
                                            <option value="iso-8859-1">Western European -> iso-8859-1</option>
                                            <option value="windows-1252">Western European -> windows-1252</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Attachment</label>
                                    <input name="userfile" type="file" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Emails</label>
                                <textarea name="emaillist" id="emaillist" class="form-control" placeholder="Emails Here"><?php echo $emaillist;?></textarea>
                                <div style="margin-top: 5px;">
                                    <button type="button" class="btn btn-info" id="countEmails" style="font-size: 12px; padding: 4px 8px;">
                                        <span id="emailCount">0</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RESULT -->
                <div class="section" id="resultSection" style="display: none;">
                    <div class="section-title">Result</div>
                    <div class="result-box" id="resultBox">
                        <!-- Results will appear here -->
                    </div>
                </div>

                <input type="hidden" name="action" value="send">
                <input type="hidden" name="dbg" value="0">
            </form>
        </div>
    </div>

    <script>
        function toggleInstruction() {
            var panel = document.getElementById('instructionPanel');
            if(panel.style.display === 'none') {
                panel.style.display = 'block';
            } else {
                panel.style.display = 'none';
            }
        }

        $(document).ready(function(){
            // Pattern Generator in Instruction
            $("#getPattern").click(function(){
                if($("#gen_az").prop("checked") || $("#gen_AZ").prop("checked") || $("#gen_09").prop("checked") && $("#gen_length").val() != "") {
                    var pattern = "##";
                    if($("#gen_az").prop("checked")) {
                        pattern += "az-";
                    }
                    if($("#gen_AZ").prop("checked")) {
                        pattern += "AZ-";
                    }
                    if($("#gen_09").prop("checked")) {
                        pattern += "09-";
                    }
                    if($("#gen_length").val() != "") {
                        pattern += "{"+$("#gen_length").val()+ "}";
                    }
                    pattern += "##";
                    $("#gen_pattern").val(pattern);
                } else {
                    $("#gen_pattern").val("");
                }
            });

            // Load saved data
            loadFormData();

            // Add SMTP
            $("#add").click(function(){
                var smtpLine = $('#ip').val()+'|'+$('#ssl_port').val()+'|'+$('#user').val()+'|'+$('#pass').val()+"|"+$('input[name=SSLTLS]:checked').val();
                if($('input[name=isbcc]').prop('checked')) {
                    smtpLine += '|BCC';
                } else {
                    smtpLine += '|NOBCC';
                }
                
                var current = $('#my_smtp').val();
                if(current == "") {
                    $('#my_smtp').val(smtpLine);
                } else {
                    $('#my_smtp').val(current + '\n' + smtpLine);
                }
                
                $('#ip').val("");
                $('#user').val("");
                $('#pass').val("");
                $('input[name=SSLTLS]').prop('checked', false);
                countSmtp(); // Update SMTP count
                saveFormData();
            });

            // Reset SMTP
            $("#reset").click(function(){
                $('#my_smtp').val('');
                countSmtp(); // Update SMTP count
                saveFormData();
            });

            // Sender email as login
            $("input[name=lase]").click(function(){
                if($('input[name=lase]').prop('checked')) {
                    $('input[name=from]').attr('disabled','disabled');
                    $('input[name=from]').val('');
                } else {
                    $('input[name=from]').removeAttr('disabled');
                }
                saveFormData();
            });

            // Reply-To as login
            $("input[name=repaslog]").click(function(){
                if($('input[name=repaslog]').prop('checked')) {
                    $('input[name=replyto]').attr('disabled','disabled');
                    $('input[name=replyto]').val('');
                } else {
                    $('input[name=replyto]').removeAttr('disabled');
                }
                saveFormData();
            });

            // Count emails - only valid emails with @
            function countEmails() {
                var emailText = $('#emaillist').val().trim();
                if(emailText === '') {
                    $('#emailCount').text('0');
                    return;
                }
                var emails = emailText.split('\n').filter(function(line) {
                    var email = line.trim();
                    // Count only non-empty lines that contain @
                    return email !== '' && email.indexOf('@') !== -1;
                });
                $('#emailCount').text(emails.length);
            }
            
            // Count SMTP servers
            function countSmtp() {
                var smtpText = $('#my_smtp').val().trim();
                if(smtpText === '') {
                    $('#smtpCount').text('0');
                    return;
                }
                var smtps = smtpText.split('\n').filter(function(line) {
                    return line.trim() !== '';
                });
                $('#smtpCount').text(smtps.length);
            }
            
            // Update count on textarea change
            $('#emaillist').on('input', function() {
                countEmails();
            });
            
            $('#my_smtp').on('input', function() {
                countSmtp();
            });
            
            // Initial counts
            countEmails();
            countSmtp();
            
            // Auto-save
            $('input, textarea, select').on('change', function() {
                saveFormData();
            });

            // Save to localStorage
            function saveFormData() {
                var formData = {
                    ip: $('#ip').val(),
                    ssl_port: $('#ssl_port').val(),
                    user: $('#user').val(),
                    my_smtp: $('#my_smtp').val(),
                    nrotat: $('input[name=nrotat]').val(),
                    reconnect: $('input[name=reconnect]').val(),
                    isbcc: $('input[name=isbcc]').prop('checked'),
                    nbcc: $('input[name=nbcc]').val(),
                    pause: $('input[name=pause]').val(),
                    pemails: $('input[name=pemails]').val(),
                    SSLTLS: $('input[name=SSLTLS]:checked').val(),
                    from: $('#from').val(),
                    realname: $('#realname').val(),
                    lase: $('input[name=lase]').prop('checked'),
                    replyto: $('#replyto').val(),
                    repaslog: $('input[name=repaslog]').prop('checked'),
                    readingconf: $('input[name=readingconf]').prop('checked'),
                    epriority: $('#epriority').val(),
                    subject: $('#subject').val(),
                    encodety: $('#encodety').val(),
                    charset: $('select[name=charset]').val(),
                    message: $('#message').val(),
                    emaillist: $('#emaillist').val(),
                    contenttype: $('input[name=contenttype]:checked').val()
                };
                localStorage.setItem('mailerFormData', JSON.stringify(formData));
            }

            // Load from localStorage
            function loadFormData() {
                var savedData = localStorage.getItem('mailerFormData');
                if(savedData) {
                    var formData = JSON.parse(savedData);
                    
                    $('#ip').val(formData.ip || '');
                    $('#ssl_port').val(formData.ssl_port || '587');
                    $('#user').val(formData.user || '');
                    $('#my_smtp').val(formData.my_smtp || '');
                    $('input[name=nrotat]').val(formData.nrotat || '0');
                    $('input[name=reconnect]').val(formData.reconnect || '0');
                    $('input[name=isbcc]').prop('checked', formData.isbcc || false);
                    $('input[name=nbcc]').val(formData.nbcc || '50');
                    $('input[name=pause]').val(formData.pause || '0');
                    $('input[name=pemails]').val(formData.pemails || '0');
                    
                    if(formData.SSLTLS) {
                        $('input[name=SSLTLS][value="'+formData.SSLTLS+'"]').prop('checked', true);
                    }
                    
                    $('#from').val(formData.from || '');
                    $('#realname').val(formData.realname || 'Support');
                    
                    // Set lase checkbox - default to true if not set
                    if(formData.hasOwnProperty('lase')) {
                        $('input[name=lase]').prop('checked', formData.lase);
                    } else {
                        $('input[name=lase]').prop('checked', true);
                    }
                    
                    if($('input[name=lase]').prop('checked')) {
                        $('#from').attr('disabled','disabled');
                    }
                    
                    $('#replyto').val(formData.replyto || '');
                    
                    // Set repaslog checkbox - default to true if not set
                    if(formData.hasOwnProperty('repaslog')) {
                        $('input[name=repaslog]').prop('checked', formData.repaslog);
                    } else {
                        $('input[name=repaslog]').prop('checked', true);
                    }
                    
                    $('input[name=readingconf]').prop('checked', formData.readingconf || false);
                    
                    if($('input[name=repaslog]').prop('checked')) {
                        $('#replyto').attr('disabled','disabled');
                    }
                    
                    $('#epriority').val(formData.epriority || '');
                    $('#subject').val(formData.subject || 'Subject Here');
                    $('#encodety').val(formData.encodety || 'no');
                    $('select[name=charset]').val(formData.charset || '');
                    $('#message').val(formData.message || 'Message Here');
                    $('#emaillist').val(formData.emaillist || 'your_email@yahoo.com');
                    
                    if(formData.contenttype) {
                        $('input[name=contenttype][value="'+formData.contenttype+'"]').prop('checked', true);
                    }
                }
            }

            // Stop Sending Handler
            $('#stopBtn').click(function(e) {
                e.preventDefault();
                
                // Disable stop button to prevent multiple clicks
                $('#stopBtn').prop('disabled', true).text('Stopping...');
                
                // Send stop signal to backend
                $.post('check_stop.php', { action: 'stop' }, function(response) {
                    $('#resultBox').append('<br><p style="color: #dc3545; font-weight: bold;">Stop signal sent. Waiting for current email to complete...</p>');
                    
                    // Auto-scroll to bottom
                    var resultBox = document.getElementById('resultBox');
                    resultBox.scrollTop = resultBox.scrollHeight;
                }).fail(function() {
                    $('#resultBox').append('<br><p style="color: #dc3545;">Failed to send stop signal.</p>');
                    $('#stopBtn').prop('disabled', false).text('Stop Sending');
                });
            });

            // AJAX Email Sending with Real-Time Streaming
            $('#sendBtn').click(function(e) {
                e.preventDefault();
                
                // Show result section
                $('#resultSection').show();
                $('#resultBox').html('');
                
                // Disable send button and show stop button
                $('#sendBtn').prop('disabled', true).text('Sending...');
                $('#stopBtn').show().prop('disabled', false).text('Stop Sending');
                
                // Prepare form data
                var formData = new FormData();
                formData.append('action', 'send');
                formData.append('dbg', '0');
                formData.append('from', $('input[name=from]').val());
                formData.append('realname', $('input[name=realname]').val());
                formData.append('replyto', $('input[name=replyto]').val());
                formData.append('subject', $('input[name=subject]').val());
                formData.append('message', $('textarea[name=message]').val());
                formData.append('emaillist', $('textarea[name=emaillist]').val());
                formData.append('my_smtp', $('textarea[name=my_smtp]').val());
                formData.append('ssl_port', $('input[name=ssl_port]').val());
                formData.append('nrotat', $('input[name=nrotat]').val());
                formData.append('reconnect', $('input[name=reconnect]').val());
                formData.append('nbcc', $('input[name=nbcc]').val());
                formData.append('pause', $('input[name=pause]').val());
                formData.append('pemails', $('input[name=pemails]').val());
                formData.append('epriority', $('select[name=epriority]').val());
                formData.append('encodety', $('select[name=encodety]').val());
                formData.append('contenttype', $('input[name=contenttype]:checked').val());
                
                if($('input[name=lase]').prop('checked')) {
                    formData.append('lase', 'true');
                }
                if($('input[name=repaslog]').prop('checked')) {
                    formData.append('repaslog', 'true');
                }
                if($('input[name=readingconf]').prop('checked')) {
                    formData.append('readingconf', 'true');
                }
                if($('input[name=isbcc]').prop('checked')) {
                    formData.append('isbcc', 'true');
                }
                
                // Add file if selected
                var fileInput = $('input[name=userfile]')[0];
                if(fileInput.files.length > 0) {
                    formData.append('userfile', fileInput.files[0]);
                }
                
                // Use fetch API for streaming support
                fetch('send.php', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    const reader = response.body.getReader();
                    const decoder = new TextDecoder();
                    
                    function readStream() {
                        reader.read().then(({done, value}) => {
                            if (done) {
                                $('#sendBtn').prop('disabled', false).text('Send message');
                                $('#stopBtn').hide();
                                return;
                            }
                            
                            // Decode and append new content
                            const text = decoder.decode(value, {stream: true});
                            $('#resultBox').append(text);
                            
                            // Auto-scroll to bottom
                            var resultBox = document.getElementById('resultBox');
                            resultBox.scrollTop = resultBox.scrollHeight;
                            
                            // Continue reading
                            readStream();
                        });
                    }
                    
                    readStream();
                }).catch(error => {
                    $('#resultBox').html('<p style="color: #dc3545;">Error: ' + error + '</p>');
                    $('#sendBtn').prop('disabled', false).text('Send message');
                    $('#stopBtn').hide();
                });
            });
        });
    </script>
</body>
</html>
