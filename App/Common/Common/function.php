<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/14
 * Time: 8:23
 */

/**
 * ��¼��־
 * @param type
 *             0: ϵͳ����
 *             1���û�����
 *             2��ҵ�����
 */
function saveLog( $type=0, $content, $userid, $username ){
    // ��������
    if ( !$content || !$userid || !$username){
        return 0;
    }
    // �����־�����ݿ���
    $id = M('SystemLog')->data(array(
        'type'     => $type,
        'content'  => $content,
        'time'     => time(),
        'userid'   => $userid,
        'username' => $username,
        'userip'   => get_client_ip()
    ))->add();

    return $id;
}

/**
 * ������ת������
 * @param $list
 * @param string $pk
 * @param string $pid
 * @param string $child
 * @param string $root
 * @return array
 */
function listToTree( $list, $pk='id', $pid='nid', $child='children', $root='0' ){
    $tree = array();
    if( is_array($list) ){
        $refer = array();
        // ���������������������ã������д洢���ǡ�����--�������á��Ķ�Ӧ��ϵ
        foreach( $list as $key => $data ){
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach( $list as $key => $data ){
            $parentId = $data[$pid];
            $list[$key]['iconCls'] = $list[$key]['icon'];
            unset($list[$key]['icon']);
            if( $root == $parentId ) {
                $tree[] =& $list[$key];
            } else {
                if( isset($refer[$parentId]) ){
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }

        }
    }

    return $tree;
}

/**
 * ��⵱ǰ�û��Ƿ�Ϊ����Ա
 * @return boolean true-����Ա��false-�ǹ���Ա
 * @author liebert
 */
function is_administrator($uid = null){
    return $uid && (intval($uid) === C('USER_ADMINISTRATOR'));
}

/**
 * ϵͳ�ǳ���MD5���ܷ���
 * @param  string $str Ҫ���ܵ��ַ���
 * @return string $key ��������
 */
function user_md5($str, $key = ''){
    return '' === $str ? '' : md5(sha1($str) . $key);
}

/**
 * ��ʽ���ֽڴ�С
 * @param  number $size      �ֽ���
 * @param  string $delimiter ���ֺ͵�λ�ָ���
 * @return string            ��ʽ����Ĵ���λ�Ĵ�С
 * @author liebert
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}


