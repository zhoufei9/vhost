<?php
namespace Home\Controller;
use Think\Controller;

class ToolsController extends BaseController {

    public function pathReversal()
    {
        // 模板输出
        $this->display();
    }

    public function calculator()
    {
        // 模板输出
        $this->display();
    }

    public function tnbr_xttz_jc()
    {
        $uid = getUid();
        $weightList = M("weight")->where('uid =' . $uid)->select();
        $bloodGlucoseValueList = M("blood_glucose_value")->where('uid =' . $uid)->select();

        $ass_weighList = [];
        foreach ($weightList as $weight) {
            $ass_weighList[] = [
                date('m/d H时', strtotime($weight['measureTime'])), round($weight['value']*2/10, 2)
            ];
        }

        $ass_bloodGlucoseValueList = [];
        foreach ($bloodGlucoseValueList as $bloodGlucoseValue) {
            $ass_bloodGlucoseValueList[] = [
                date('m/d H时', strtotime($bloodGlucoseValue['measureTime'])), $bloodGlucoseValue['value']
            ];
        }
        $lastList['t'] = end($weightList);
        $lastList['x'] = end($bloodGlucoseValueList);

        $this->assign([
            'lastList' => $lastList,
            'ass_weighList' => json_encode($ass_weighList),
            'ass_bloodGlucoseValueList' => json_encode($ass_bloodGlucoseValueList),
        ]);
        $this->display();
    }

    public function addWeight()
    {
        $data['value'] = I('post.tz');
        $data['measureTime'] = I('post.date_t');

        $data['measureTime'] = $data['measureTime'] ? $data['measureTime'] : date('Y-m-d H:i:s');
        $data['uid'] = 1;
        M("weight")->add($data);
        $this->ajaxReturn(['code' => 0]);
    }
    public function addBloodGlucoseValue()
    {
        $data['value'] = I('post.xtz');
        $data['measureTime'] = I('post.date_x');

        $data['measureTime'] = $data['measureTime'] ? $data['measureTime'] : date('Y-m-d H:i:s');
        $data['uid'] = getUid();
        M("blood_glucose_value")->add($data);
        $this->ajaxReturn(['code' => 0]);
    }

    public function actionHabit()
    {
        $action = I('post.action');
        $id = (int)I('post.id');
        $name = I('post.name');

        $todayDate = date('Ymd');
        if ($action == 'false') {
            $data['id'] = $id;
            $data['endDate'] = $todayDate;
            M("habitStickTolt")->save($data);
        } elseif ($action == 'true') {
            $detail = M("habitStickTolt")->find($id);
            if ($detail['startDate'] == $todayDate) {
                //防止误点击重复添加
                $detail['endDate'] = null;
                M("habitStickTolt")->save($detail);
            } else {
                $data['name'] = $name;
                $data['uid'] = getUid();
                $data['startDate'] = $todayDate;
                M("habitStickTolt")->add($data);
            }
        }
        $this->ajaxReturn(['code' => 0]);
    }

    public function addHabit()
    {
        $name = I('post.name');
        $date = I('post.date');

        if (empty($name)) {
            return false;
        }

        if (empty($date)) $date = date('Y-m-d');
        $start_time = str_replace('-', '', $date);

        $data['name'] = $name;
        $uid = getUid();
        $exist = M("habitStickTolt")->where('uid = ' . $uid . ' and name = "' . $data['name'] . '" and endDate is null')->find();
        if ($exist) {
            $this->ajaxReturn(['code' => 10000, 'msg' => '操作失败，习惯正在进行中']);
        }
        $data['startDate'] = $start_time;
        $data['uid'] = $uid;

        M("habitStickTolt")->add($data);
        $this->ajaxReturn(['code' => 0]);
    }

    public function habitStickToIt()
    {
        $now_time = time();
        $today_date = date("Y/m/d", $now_time);
        $uid = getUid();

        $allHabitClass = [];
        $stickToltData = [];
        $habitList = M("habitStickTolt")->where('uid =' . $uid)->select();

        $cycleList = [];
        foreach ($habitList as &$v) {
            $allHabitClass[$v['name']] = $v;
            $cycleList[$v['name']] ++;
            $start_time = $v['startDate'];
            $kssj = (int)strtotime((string)$start_time);
            $endTime = $v['endDate'] ? strtotime($v['endDate']) : $now_time;
            $cxts = ($endTime - $kssj) / 86400;
            $stickToltData[$v['name']][] = [$this->strToDate($start_time), ceil($cxts), $v['endDate'] ? $this->strToDate($v['endDate']) : '--', $cycleList[$v['name']]];
        }

        $this->assign([
            'today_date' => $today_date,
            'allHabitClass' => $allHabitClass,
            'habitList' => $habitList,
            'stickToltData' => $stickToltData,
            'stickToltDataKeyList' => json_encode(array_keys($stickToltData), JSON_UNESCAPED_UNICODE)
        ]);

        $this->display();
    }



    public function strToDate($num) {
        return  date('Y/m/d', strtotime($num));
    }
}