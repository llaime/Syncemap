<?php
function SyncImapEmail($userOut, $passOut, $userIn, $passIn, $domOut, $domIn){

$sourcestream = imap_open("{" . $domOut . "}", $userOut, $passOut);
$deststream = imap_open("{" . $domIn . "}", $userIn, $passIn);
if ($sourcestream && $deststream) {

    $list = imap_list($sourcestream, "{" . $domOut . "}", "*");
    $destlist = imap_list($deststream, "{" . $domIn . "}", "*");
    print_r($destlist);
    if (is_array($list)) {
        foreach ($list as $mailbox) {
            $pos = strpos($mailbox, "}");
            $mailbox = substr($mailbox, $pos + 1);
            $sourcembox = imap_open("{" . $domOut . "}" . $mailbox, $userOut, $passOut);
            if ($sourcembox) {
                if (!array_search("{" . $domIn . "}" . $mailbox, $destlist)) {
                    // DEBUG // echo "Creating mailbox $mailbox on $domIn ";
                    /* if (imap_createmailbox($deststream, imap_utf7_encode("{" . $domIn . "}" . $mailbox))) {
                            echo "done\n";
                        } else {
                            echo "NOT done\n";
                        }
                        */
                }

                $destmbox = imap_open("{" . $domIn . "}" . $mailbox, $userIn, $passIn);

                if ($destmbox) {
                    $headers = imap_headers($sourcembox);
                    $total = count($headers);
                    $n = 1;
                    echo "$total items in $mailbox\n";
                    if ($headers) {
                        foreach ($headers as $key => $thisHeader) {
                            // echo "copying $n of $total... ";
                            $header = imap_headerinfo($sourcembox, $key + 1);
                            $is_unseen = $header->Unseen;
                            // echo "is_unseen = $is_unseen";
                            // $is_recent = $header->Recent;
                            // echo "is_recent = $is_recent";
                            $messageHeader = imap_fetchheader($sourcembox, $key + 1);
                            $body = imap_body($sourcembox, $key + 1);
                            if (imap_append($destmbox, "{" . $domIn . "}" . $mailbox, $messageHeader . "\r\n" . $body)) {
                                if ($is_unseen != "U") {
                                    if (!imap_setflag_full($destmbox, $key + 1, '\\SEEN')) {
                                        // echo "couldn't set \\SEEN flag";
                                    }
                                }
                                //echo "done\n";
                            } else {
                                // echo "NOT done\n";
                            }
                            $n++;
                        }
                    }
                    imap_close($destmbox);
                }
                imap_close($sourcembox);
            }
        }
    }
}
imap_close($sourcestream);
imap_close($deststream);
}
?>