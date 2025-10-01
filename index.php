<?php
error_reporting(0);
set_time_limit(0);

function randString($consonants) {
    $length=rand(12,25);
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $consonants[(rand() % strlen($consonants))];
    }
    return $password;
}

function lufClear($text,$email){
    $e = explode('@', $email);
    $emailuser=$e[0];
    $emaildomain=$e[1];
    $text = str_replace("[-time-]", date("m/d/Y h:i:s a", time()), $text);
    $text = str_replace("[-email-]", $email, $text);
    $text = str_replace("[-emailuser-]", $emailuser, $text);
    $text = str_replace("[-emaildomain-]", $emaildomain, $text);
    $text = str_replace("[-randomletters-]", randString('abcdefghijklmnopqrstuvwxyz'), $text);
    $text = str_replace("[-randomstring-]", randString('abcdefghijklmnopqrstuvwxyz0123456789'), $text);
    $text = str_replace("[-randomnumber-]", randString('0123456789'), $text);
    $text = str_replace("[-randommd5-]", md5(randString('abcdefghijklmnopqrstuvwxyz0123456789')), $text);
    return $text;  
}

$message_base="Message Here";
$action="";
$message="ilpasha";
$emaillist="your_email@yahoo.com";
$from="";
$reconnect="0";
$epriority="";
$my_smtp="";
$ssl_port="587";
$encodety="";
$replyto="";
$subject="Yes";
$realname="Yes Man";
$subject_base="Subject Here";
$realname_base="Support";
$contenttype="";
$isbcc="";
$nbcc="50";
$default_system="";
$from_base="";
$debg="0";
$pause=0;
$pemails=0;
$nm=0;
$nopose=true;
$nrotat=0;
$curentsmtp=0;
$canrotat=false;
$allsmtps="";
$lase="";
$reading=false;
$repaslog=false;
$uploadfile="";

if(!empty($_POST)) {	  
    $debg=lrtrim($_POST['dbg']);
    if(!empty($_POST['from'])) {
        $from=lrtrim($_POST['from']);
        $from_base =$from;
    }
    $action=lrtrim($_POST['action']);
    $message=lrtrim($_POST['message']);
    $message_base=lrtrim($_POST['message']);
    $emaillist=lrtrim($_POST['emaillist']);
    $reconnect=lrtrim($_POST['reconnect']);
    $epriority=lrtrim($_POST['epriority']);
    $my_smtp=lrtrim($_POST['my_smtp']);
    $subject=lrtrim($_POST['subject']);
    $realname=lrtrim($_POST['realname']);
    $subject_base=lrtrim($_POST['subject']);
    $realname_base=lrtrim($_POST['realname']);
    $contenttype=lrtrim($_POST['contenttype']);
    $encodety=$_POST['encodety'];
    if(!empty($_POST['pause']))
        $pause=$_POST['pause'];
    if(!empty($_POST['replyto']))
        $replyto=lrtrim($_POST['replyto']);
    if(!empty($_POST['nrotat']))
        $nrotat=$_POST['nrotat'];
    if(!empty($_POST['pemails']))
        $pemails=$_POST['pemails'];
    if(!empty($_POST['lase']))
        $lase=true;
    if(!empty($_POST['nbcc']))
        $nbcc=lrtrim($_POST['nbcc']);
    $allsmtps =  preg_split("/\\r\\n|\\r|\\n/", $my_smtp);
    if(!empty($_POST['readingconf']))
        $reading=true;
    if(!empty($_POST['repaslog']))
        $repaslog=true;
}

// Include PHPMailer classes from mailler.php
require_once 'mailler.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Mailer - Professional Interface</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 24px 32px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 14px;
            color: #6b7280;
        }

        .content {
            padding: 32px;
        }

        .section {
            background: #fafafa;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e5e7eb;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s;
            background: white;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-control:disabled {
            background: #f3f4f6;
            color: #9ca3af;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        select.form-control {
            cursor: pointer;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            padding: 8px 0;
        }

        .checkbox-group input[type="checkbox"],
        .checkbox-group input[type="radio"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #3b82f6;
        }

        .checkbox-group label {
            font-size: 13px;
            color: #4b5563;
            cursor: pointer;
            user-select: none;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-success {
            background: #10b981;
            color: white;
            padding: 12px 32px;
            font-size: 15px;
        }

        .btn-success:hover {
            background: #059669;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 16px;
        }

        .smtp-display {
            background: #1f2937;
            color: #d1d5db;
            padding: 16px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            min-height: 100px;
            max-height: 200px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .info-alert {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-left: 4px solid #3b82f6;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 13px;
            color: #1e40af;
            margin: 16px 0;
        }

        .help-section {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            border-radius: 6px;
            margin-top: 24px;
        }

        .help-section h4 {
            color: #92400e;
            margin-bottom: 12px;
            font-size: 15px;
            font-weight: 600;
        }

        .help-section ul {
            list-style: none;
            padding-left: 0;
        }

        .help-section li {
            padding: 6px 0;
            padding-left: 20px;
            position: relative;
            font-size: 13px;
            color: #78350f;
        }

        .help-section li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #f59e0b;
            font-weight: bold;
        }

        .help-section code {
            background: rgba(245, 158, 11, 0.15);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: #92400e;
            font-weight: 600;
            font-size: 12px;
        }

        .toggle-help {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s;
        }

        .toggle-help:hover {
            background: #d97706;
        }

        #more {
            display: none;
            margin-top: 16px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background: #fafafa;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 13px;
        }

        .inline-flex {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .w-full {
            width: 100%;
        }

        .pattern-builder {
            background: white;
            border: 1px solid #e5e7eb;
            padding: 16px;
            border-radius: 6px;
            margin-top: 12px;
        }

        .pattern-builder label {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-right: 12px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 PHP Mailer</h1>
            <p>Professional Email Sending Interface</p>
        </div>
        
        <div class="content">
            <form name="form1" method="post" action="" enctype="multipart/form-data" id="mailerForm">
                
                <!-- SERVER SETUP -->
                <div class="section">
                    <div class="section-title">Server Configuration</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Debug Level</label>
                            <select name="dbg" id="dbg" class="form-control">
                                <option value="0" <?php echo ($debg == "0") ? 'selected':''; ?>>OFF</option>
                                <option value="1" <?php echo ($debg == "1") ? 'selected':''; ?>>Level 1</option>
                                <option value="2" <?php echo ($debg == "2") ? 'selected':''; ?>>Level 2</option>
                                <option value="3" <?php echo ($debg == "3") ? 'selected':''; ?>>Level 3</option>
                                <option value="4" <?php echo ($debg == "4") ? 'selected':''; ?>>Level 4</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>SMTP Host</label>
                            <input type="text" id="ip" name="ip" class="form-control" placeholder="smtp.example.com">
                        </div>
                        
                        <div class="form-group">
                            <label>Port</label>
                            <input type="text" name="ssl_port" id="ssl_port" value="<?php echo $ssl_port;?>" class="form-control" placeholder="587">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>SMTP Username</label>
                            <input type="text" id="user" name="user" class="form-control" placeholder="your@email.com">
                        </div>
                        
                        <div class="form-group">
                            <label>SMTP Password</label>
                            <input type="password" id="pass" name="pass" class="form-control" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>SSL/TLS Type</label>
                            <div class="checkbox-group">
                                <input type="radio" name="SSLTLS" value="SSL" id="ssl">
                                <label for="ssl">SSL</label>
                                <input type="radio" name="SSLTLS" value="TLS" id="tls">
                                <label for="tls">TLS</label>
                                <input type="radio" name="SSLTLS" value="NON" id="non">
                                <label for="non">None</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Reconnect After (emails)</label>
                            <input type="text" name="reconnect" value="<?php echo $reconnect;?>" class="form-control" placeholder="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>BCC Settings</label>
                            <div class="checkbox-group">
                                <input type="checkbox" name="isbcc" value="true" id="isbcc" <?php if($isbcc=="true") echo "checked"; ?>>
                                <label for="isbcc">Enable BCC</label>
                                <input type="text" name="nbcc" value="<?php echo $nbcc;?>" class="form-control" placeholder="50" style="width: 100px;">
                                <label>emails per BCC</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Send Pause</label>
                            <div class="inline-flex">
                                <input type="text" name="pause" value="<?php echo $pause;?>" class="form-control" placeholder="0" style="width: 80px;">
                                <span style="font-size: 13px; color: #6b7280;">sec every</span>
                                <input type="text" name="pemails" value="<?php echo $pemails;?>" class="form-control" placeholder="0" style="width: 80px;">
                                <span style="font-size: 13px; color: #6b7280;">emails</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>SMTP Configuration</label>
                        <div style="display: grid; grid-template-columns: 1fr auto; gap: 12px;">
                            <textarea readonly id="my_smtp" name="my_smtp" class="smtp-display"><?php echo $my_smtp;?></textarea>
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <button type="button" class="btn btn-primary" id="add">➕ Add SMTP</button>
                                <button type="button" class="btn btn-danger" id="reset">🗑️ Reset</button>
                            </div>
                        </div>
                        <div class="inline-flex" style="margin-top: 12px;">
                            <span style="font-size: 13px; color: #6b7280;">Rotate every</span>
                            <input name="nrotat" type="text" value="<?php echo $nrotat;?>" class="form-control" placeholder="0" style="width: 80px;">
                            <span style="font-size: 13px; color: #6b7280;">emails</span>
                        </div>
                    </div>

                    <div class="info-alert">
                        💡 If you don't have SMTP login information, leave blank to send with localhost
                    </div>
                </div>

                <!-- MESSAGE SETUP -->
                <div class="section">
                    <div class="section-title">Message Configuration</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Your Email</label>
                            <div class="checkbox-group">
                                <input type="text" name="from" id="from" value="<?php if(!$lase) echo $from_base;?>" class="form-control" placeholder="sender@example.com" <?php if($lase) echo "disabled"?> style="flex: 1;">
                                <input type="checkbox" name="lase" value="true" id="lase" <?php if($lase) echo "checked"; ?>>
                                <label for="lase">Use SMTP Login</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Your Name</label>
                            <input type="text" name="realname" id="realname" value="<?php echo $realname_base;?>" class="form-control" placeholder="John Doe">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Reply-To</label>
                            <div class="checkbox-group">
                                <input type="text" name="replyto" id="replyto" value="<?php if(!$repaslog) echo $replyto;?>" class="form-control" placeholder="reply@example.com" <?php if($repaslog) echo "disabled";?> style="flex: 1;">
                                <input type="checkbox" name="repaslog" value="true" id="repaslog" <?php if($repaslog) echo "checked"; ?>>
                                <label for="repaslog">Use Login</label>
                                <input type="checkbox" name="readingconf" value="true" id="readingconf" <?php if($reading) echo "checked"; ?>>
                                <label for="readingconf">Confirm Reading</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Email Priority</label>
                            <select name="epriority" id="epriority" class="form-control">
                                <option value="" <?php if(strlen($epriority)< 1){print "selected";} ?>>No Priority</option>
                                <option value="1" <?php if($epriority == "1"){print "selected";} ?>>High</option>
                                <option value="3" <?php if($epriority == "3"){print "selected";} ?>>Normal</option>
                                <option value="5" <?php if($epriority == "5"){print "selected";} ?>>Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" id="subject" value="<?php echo $subject_base;?>" class="form-control" placeholder="Email Subject">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Encoding</label>
                            <select name="encodety" id="encodety" class="form-control">
                                <option value="no" <?php if($encodety == "no"){print "selected";} ?>>No Encoding</option>
                                <option value="8bit" <?php if($encodety == "8bit"){print "selected";} ?>>8bit</option>
                                <option value="7bit" <?php if($encodety == "7bit"){print "selected";} ?>>7bit</option>
                                <option value="binary" <?php if($encodety == "binary"){print "selected";} ?>>Binary</option>
                                <option value="base64" <?php if($encodety == "base64"){print "selected";} ?>>Base64</option>
                                <option value="quoted-printable" <?php if($encodety == "quoted-printable"){print "selected";} ?>>Quoted-Printable</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Attachment</label>
                            <input name="userfile" type="file" class="form-control">
                        </div>
                    </div>

                    <div class="pattern-builder">
                        <label><strong>Pattern Generator</strong></label>
                        <div class="checkbox-group">
                            <input type="checkbox" name="az" id="az">
                            <label for="az">(a-z)</label>
                            <input type="checkbox" name="AZ" id="AZ">
                            <label for="AZ">(A-Z)</label>
                            <input type="checkbox" name="09" id="09">
                            <label for="09">(0-9)</label>
                            <input type="text" name="len" id="len" class="form-control" placeholder="Length" style="width: 80px;">
                            <input type="text" name="patval" id="patval" class="form-control" placeholder="Pattern" style="width: 200px;">
                            <button type="button" class="btn btn-secondary" id="patb">Generate</button>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 20px;">
                        <div class="form-group">
                            <label>Message Body</label>
                            <textarea name="message" id="message" class="form-control" placeholder="Enter your message here..."><?php echo $message_base;?></textarea>
                            <div class="checkbox-group">
                                <input type="radio" name="contenttype" value="plain" id="plain">
                                <label for="plain">Plain Text</label>
                                <input type="radio" name="contenttype" value="html" id="html" checked>
                                <label for="html">HTML</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Email List (one per line)</label>
                            <textarea name="emaillist" id="emaillist" class="form-control" placeholder="email1@example.com&#10;email2@example.com&#10;email3@example.com"><?php echo $emaillist;?></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="action" value="send">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">🚀 Send Emails</button>
                        <button type="button" class="btn btn-secondary" id="saveData">💾 Save Data</button>
                        <button type="button" class="btn btn-secondary" id="loadData">📂 Load Data</button>
                        <button type="button" class="btn btn-danger" id="clearData">🗑️ Clear All</button>
                    </div>
                </div>

                <!-- HELP SECTION -->
                <div class="help-section">
                    <h4>📚 Help & Variables<span id="dots">...</span></h4>
                    <button type="button" onclick="readmore()" id="readmorebtn" class="toggle-help">Read more</button>
                    <div id="more">
                        <ul>
                            <li><code>[-email-]</code> : Receiver Email (emailuser@emaildomain.com)</li>
                            <ul style="margin-left: 20px;">
                                <li><code>[-emailuser-]</code> : Email User (emailuser)</li>
                                <li><code>[-emaildomain-]</code> : Email Domain (emaildomain.com)</li>
                            </ul>
                            <li><code>[-time-]</code> : Date and Time (03/04/2021 02:41:23 pm)</li>
                            <li><code>[-randomstring-]</code> : Random string (0-9,a-z)</li>
                            <li><code>[-randomnumber-]</code> : Random number (0-9)</li>
                            <li><code>[-randomletters-]</code> : Random Letters (a-z)</li>
                            <li><code>[-randommd5-]</code> : Random MD5</li>
                        </ul>
                        <h4 style="margin-top: 16px;">Example:</h4>
                        <p style="font-size: 13px; color: #78350f;">Receiver Email = <strong>user@domain.com</strong></p>
                        <ul>
                            <li>hello <code>[-emailuser-]</code> = hello <strong>user</strong></li>
                            <li>your domain is <code>[-emaildomain-]</code> = your domain is <strong>domain.com</strong></li>
                            <li>your code is <code>[-randommd5-]</code> = your code is <strong>e10adc3949ba59abbe56e057f20f883e</strong></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

        <div class="footer">
            <p>PHP Mailer &copy; <?php echo date("Y"); ?> | Professional Email Solution</p>
        </div>
    </div>

    <script>
        function readmore() {
            var dots = document.getElementById("dots");
            var moreText = document.getElementById("more");
            var btnText = document.getElementById("readmorebtn");

            if (dots.style.display === "none") {
                dots.style.display = "inline";
                btnText.innerHTML = "Read more"; 
                moreText.style.display = "none";
            } else {
                dots.style.display = "none";
                btnText.innerHTML = "Read less"; 
                moreText.style.display = "inline";
            }
        }

        $(document).ready(function(){
            // Load saved data on page load
            loadFormData();

            // Pattern generator
            $("#patb").click(function(){
                if($("#az").prop("checked") || $("#AZ").prop("checked") || $("#09").prop("checked") && $("#len").val() != "") {
                    $("#patval").val("");
                    $("#patval").val($("#patval").val() + "##");
                    if($("#az").prop("checked")) {
                        $("#patval").val($("#patval").val() + "az-");
                    }
                    if($("#AZ").prop("checked")) {
                        $("#patval").val($("#patval").val() + "AZ-");
                    }
                    if($("#09").prop("checked")) {
                        $("#patval").val($("#patval").val() + "09-");
                    }
                    if($("#len").val() != "") {
                        $("#patval").val($("#patval").val() + "{"+$("#len").val()+ "}");
                    }
                    $("#patval").val($("#patval").val() + "##");
                } else {
                    $("#patval").val("");
                }
                saveFormData();
            });

            // Add SMTP to config
            $("#add").click(function(){
                var smtpLine = $('#ip').val()+':'+$('#ssl_port').val()+':'+$('#user').val()+':'+$('#pass').val()+":"+$('input[name=SSLTLS]:checked').val();
                if($('input[name=isbcc]').prop('checked')) {
                    smtpLine += ':BCC';
                } else {
                    smtpLine += ':NOBCC';
                }
                
                if($('#my_smtp').val() == "") {
                    $('#my_smtp').val(smtpLine);
                } else {
                    $('#my_smtp').val($('#my_smtp').val() + '\n' + smtpLine);
                }
                
                $('#ip').val("");
                $('#user').val("");
                $('#pass').val("");
                $('input[name=SSLTLS]').prop('checked', false);
                saveFormData();
            });

            // Reset SMTP config
            $("#reset").click(function(){
                $('#my_smtp').val('');
                saveFormData();
            });

            // Email as LOGIN checkbox
            $("input[name=lase]").click(function(){
                if($('input[name=lase]').prop('checked')) {
                    $('input[name=from]').attr('disabled','disabled');
                    $('input[name=from]').val('');
                } else {
                    $('input[name=from]').removeAttr('disabled');
                }
                saveFormData();
            });

            // Reply as LOGIN checkbox
            $("input[name=repaslog]").click(function(){
                if($('input[name=repaslog]').prop('checked')) {
                    $('input[name=replyto]').attr('disabled','disabled');
                    $('input[name=replyto]').val('');
                } else {
                    $('input[name=replyto]').removeAttr('disabled');
                }
                saveFormData();
            });

            // Auto-save on input change
            $('input, textarea, select').on('change', function() {
                saveFormData();
            });

            // Save data button
            $("#saveData").click(function(){
                saveFormData();
                alert('✅ Data saved successfully!');
            });

            // Load data button
            $("#loadData").click(function(){
                loadFormData();
                alert('✅ Data loaded successfully!');
            });

            // Clear all data button
            $("#clearData").click(function(){
                if(confirm('Are you sure you want to clear all saved data?')) {
                    localStorage.clear();
                    location.reload();
                }
            });

            // Save form data to localStorage
            function saveFormData() {
                var formData = {
                    dbg: $('#dbg').val(),
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
                    message: $('#message').val(),
                    emaillist: $('#emaillist').val(),
                    contenttype: $('input[name=contenttype]:checked').val()
                };
                localStorage.setItem('mailerFormData', JSON.stringify(formData));
            }

            // Load form data from localStorage
            function loadFormData() {
                var savedData = localStorage.getItem('mailerFormData');
                if(savedData) {
                    var formData = JSON.parse(savedData);
                    
                    $('#dbg').val(formData.dbg || '0');
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
                    $('input[name=lase]').prop('checked', formData.lase || false);
                    
                    if(formData.lase) {
                        $('#from').attr('disabled','disabled');
                    }
                    
                    $('#replyto').val(formData.replyto || '');
                    $('input[name=repaslog]').prop('checked', formData.repaslog || false);
                    $('input[name=readingconf]').prop('checked', formData.readingconf || false);
                    
                    if(formData.repaslog) {
                        $('#replyto').attr('disabled','disabled');
                    }
                    
                    $('#epriority').val(formData.epriority || '');
                    $('#subject').val(formData.subject || 'Subject Here');
                    $('#encodety').val(formData.encodety || 'no');
                    $('#message').val(formData.message || 'Message Here');
                    $('#emaillist').val(formData.emaillist || 'your_email@yahoo.com');
                    
                    if(formData.contenttype) {
                        $('input[name=contenttype][value="'+formData.contenttype+'"]').prop('checked', true);
                    }
                }
            }
        });
    </script>
</body>
</html>
