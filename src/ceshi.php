<?php
//num,org

echo '测试Composer2';
exit;
$action = $_GET['action'];
if ($action == 'num') {
    
    $numUrl = 'http://134.176.42.45:9090/api/rest';
    $param = file_get_contents("php://input");
    $result = http_post_data($numUrl,$param);
    //$result = '{"res_code":"00000","res_message":"Success","result":{"Body":{"IfServiceResponse":{"IfServiceReturn":{"IfResponse":{"TransactionID":"ZDAQ202010281123053131450001","RspTime":"20201212161751","Response":{"RspType":"0","RspCode":"0000","RspDesc":"执行成功！","data":{"staff_info":{"staff_name":"CRM故障处理","sale_box_name":"长沙市电信分公司@功能测试部门","common_region_name":"长沙市_市辖区","address":"湖南省长沙市雨花区东塘街道","org_code":"110000003511"}}}}}}}}}';
    echo $result;
} else if ($action == 'org') {
    
    //$numUrl = 'http://134.176.102.33:9080/api/openapi/hn/cpcp/queryOrgInfo';
    $numUrl = 'http://134.176.102.33:8081/api/openapi/hn/cpcp/queryOrgInfo/queryOrgInfo';
    $param = file_get_contents("php://input");
    $result = http_post_data($numUrl,$param,'1');
    echo $result;
}

function http_post_data($url, $data, $head='') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    if ($head =='') {

        $hearAry =  array(
            "Content-Type: application/json; charset=UTF-8",
            "Content-Length: " . strlen($data)
        );
    } else {

        $hearAry =  array(
            "Content-Type: application/json; charset=UTF-8",
            "Content-Length: " . strlen($data),
            "X-APP-ID:a5ec5c92e9aa87be4fd23f5e8975c83d",
            "X-APP-KEY:5a05afd9365ee8cfef87894ae4392968",
            "X-CTG-VERSION: V1.0.00"
        );
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $hearAry
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 6秒超时，确保15秒内返回结果
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    //ob_start();
    $return_content = curl_exec($ch);
    curl_close($ch);
    //$return_content = ob_get_contents();
    //ob_end_clean();
    return $return_content;
}
/**
 * ZDAQ+yyymmddhh24miss+10位序列
 */
function getTransactionID () {

    $transID = 'ZDAQ';
    $date = date('YmdHis',time());
    $order = makeOrder();
    $result = $transID.$date.$order;
    return $result;
}
function makeOrder( $length = 10 ) {
    // 密码字符集，可任意添加你需要的字符
    $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9','0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    // 在 $chars 中随机取 $length 个数组元素键名
    $keys = array_rand($chars, $length);
    $password = '';
    for($i = 0; $i < $length; $i++)
    {
        // 将 $length 个数组元素连接成字符串
        $password .= $chars[$keys[$i]];
    }
    return $password;
}
//字符串处理
function hndx_strReplace($str) {
    $str = str_replace('\\', '\\\\', $str);
    $str = str_replace('"', '\"', $str);
    $str = str_replace("'", "\'", $str);
    return $str;
}
?>