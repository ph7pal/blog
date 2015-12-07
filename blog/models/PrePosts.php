<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pre_posts".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $colid
 * @property string $title
 * @property string $content
 * @property integer $hits
 * @property integer $cTime
 * @property integer $updateTime
 * @property integer $status
 * @property integer $top
 * @property integer $favors
 * @property string $lat
 * @property string $long
 * @property integer $mapZoom
 * @property string $sourceurl
 * @property string $sourceinfo
 * @property string $keywords
 * @property string $description
 * @property integer $classify
 * @property integer $comments
 * @property string $platform
 * @property integer $areaid
 * @property string $redirect
 * @property string $nearby
 * @property integer $faceimg
 * @property integer $favorite
 * @property string $tagids
 * @property integer $groupid
 */
class PrePosts extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pre_posts';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['uid'], 'default','value' => Yii::$app->user->id],
            [['cTime', 'updateTime'], 'default','value' => time()],
            [['status'], 'default','value' => 1],
            [['uid', 'colid', 'title', 'content'], 'required'],
            [['sourceurl'], 'url','defaultScheme' => 'http'],
            [['uid', 'colid', 'hits', 'cTime', 'updateTime', 'status', 'top', 'favors', 'mapZoom', 'classify', 'comments', 'areaid', 'faceimg', 'favorite', 'groupid'], 'integer'],
            [['content'], 'string'],
            [['title', 'sourceurl', 'sourceinfo', 'keywords', 'description', 'redirect', 'nearby', 'tagids'], 'string', 'max' => 255],
            [['lat', 'long'], 'string', 'max' => 50],
            [['platform'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'uid' => '作者',
            'colid' => '分类',
            'title' => '标题',
            'content' => '正文',
            'hits' => '点击',
            'cTime' => '创建时间',
            'updateTime' => '更新时间',
            'status' => 'Status',
            'top' => 'Top',
            'favors' => 'Favors',
            'lat' => 'Lat',
            'long' => 'Long',
            'mapZoom' => 'Map Zoom',
            'sourceurl' => '来源地址',
            'sourceinfo' => '来源',
            'keywords' => '关键词',
            'description' => '描述',
            'classify' => '分类',
            'comments' => 'Comments',
            'platform' => 'Platform',
            'areaid' => 'Areaid',
            'redirect' => 'Redirect',
            'nearby' => 'Nearby',
            'faceimg' => 'Faceimg',
            'favorite' => 'Favorite',
            'tagids' => '标签组',
            'groupid' => '所属团队',
        ];
    }

    public static function stripStr($string) {
        $string = strip_tags($string);
        $replace = array(
            '/\[attach\](\d+)\[\/attach\]/i',
            '/\[atone\](\d+)\[\/atone\]/i',
            "/\[url=.+?\](.+?)\[\/url\]/i",
            "/\[texturl=.+?\].+?\[\/texturl\]/i",
            "/\[poi=.+?\](.+?)\[\/poi\]/i",
        );
        $to = array(
            '',
            '',
            '$1',
            '',
            '$1',
        );
        $string = preg_replace($replace, $to, $string);
        return $string;
    }

    public static function cutstr($string, $length, $dot = ' ...', $charset = 'utf-8') {
        $string=  self::stripStr($string);
        if (strlen($string) <= $length) {
            return $string;
        }
        $pre = chr(1);
        $end = chr(1);
        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre . '&' . $end, $pre . '"' . $end, $pre . '<' . $end, $pre . '>' . $end), $string);
        $strcut = '';
        if (strtolower($charset) == 'utf-8') {
            $n = $tn = $noc = 0;
            while ($n < strlen($string)) {
                $t = ord($string[$n]);
                if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1;
                    $n++;
                    $noc++;
                } elseif (194 <= $t && $t <= 223) {
                    $tn = 2;
                    $n += 2;
                    $noc += 2;
                } elseif (224 <= $t && $t <= 239) {
                    $tn = 3;
                    $n += 3;
                    $noc += 2;
                } elseif (240 <= $t && $t <= 247) {
                    $tn = 4;
                    $n += 4;
                    $noc += 2;
                } elseif (248 <= $t && $t <= 251) {
                    $tn = 5;
                    $n += 5;
                    $noc += 2;
                } elseif ($t == 252 || $t == 253) {
                    $tn = 6;
                    $n += 6;
                    $noc += 2;
                } else {
                    $n++;
                }
                if ($noc >= $length) {
                    break;
                }
            }
            if ($noc > $length) {
                $n -= $tn;
            }
            $strcut = substr($string, 0, $n);
        } else {
            $_length = $length - 1;
            for ($i = 0; $i < $length; $i++) {
                if (ord($string[$i]) <= 127) {
                    $strcut .= $string[$i];
                } else if ($i < $_length) {
                    $strcut .= $string[$i] . $string[++$i];
                }
            }
        }
        $strcut = str_replace(array($pre . '&' . $end, $pre . '"' . $end, $pre . '<' . $end, $pre . '>' . $end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
        $pos = strrpos($strcut, chr(1));
        if ($pos !== false) {
            $strcut = substr($strcut, 0, $pos);
        }
        return $strcut . $dot;
    }

    public function text($content, $lazyload = true, $size = 600, $action = '') {
        if ($action != 'edit') {
            //$content = tools::addcontentlink($content);
        } else {
            $lazyload = false;
        }
        if (strpos($content, '[attach]') !== false) {
            preg_match_all("/\[attach\](\d+)\[\/attach\]/i", $content, $match);
            if (!empty($match[1])) {
                foreach ($match[1] as $key => $val) {
                    $thekey = $match[0][$key];
                    $src = Attachments::model()->findByPk($val);
                    if ($src) {
                        $_imgurl = self::uploadDirs($src['cTime'], 'site', $src['classify'], $size) . $src['filePath'];
                        $imgurl = self::uploadDirs($src['cTime'], 'app', $src['classify'], $size) . $src['filePath'];
                        if ($lazyload) {
                            $filesize = getimagesize($imgurl);
                            if (empty($filesize)) {
                                $content = str_ireplace("{$thekey}", '', $content);
                                continue;
                            }
                            $imgurl = "<img src='" . self::lazyImg() . "' width='" . $filesize[0] . "px' height='" . $filesize[1] . "' class='lazy img-responsive' data-original='{$_imgurl}' " . ($action == 'edit' ? 'data="' . $src['id'] . '"' : '') . "/>";
                        } else {
                            $imgurl = "<img src='{$_imgurl}' class='img-responsive' " . ($action == 'edit' ? 'data="' . $src['id'] . '"' : '') . "/>";
                        }
                        $content = str_ireplace("{$thekey}", $imgurl, $content);
                    } else {
                        $content = str_ireplace("{$thekey}", '', $content);
                    }
                }
            }
        }
        $content = self::handleContent($content);
        return $content;
    }

}
