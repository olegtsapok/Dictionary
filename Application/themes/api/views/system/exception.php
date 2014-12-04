
<?php echo $data['type']?>


<?php echo $data['message']?>


<?php echo htmlspecialchars($data['file'],ENT_QUOTES,Yii::app()->charset)."({$data['line']})"?>


<?php echo $this->renderSourceCode($data['file'],$data['line'],$this->maxSourceLines); ?>


Stack Trace
<?php $count=0; ?>
<?php foreach($data['traces'] as $n => $trace): ?>
        <?php
                if($this->isCoreCode($trace))
                        $cssClass='core collapsed';
                elseif(++$count>3)
                        $cssClass='app collapsed';
                else
                        $cssClass='app expanded';
                $hasCode=$trace['file']!=='unknown' && is_file($trace['file']);
        ?>



        <?php
                echo htmlspecialchars($trace['file'],ENT_QUOTES,Yii::app()->charset)."(".$trace['line'].")";
                echo ': ';
                if(!empty($trace['class']))
                        echo "<strong>{$trace['class']}</strong>{$trace['type']}";
                echo "<strong>{$trace['function']}</strong>(";
                if(!empty($trace['args']))
                        echo htmlspecialchars($this->argumentsToString($trace['args']),ENT_QUOTES,Yii::app()->charset);
                echo ')';
        ?>

        <?php if($hasCode) echo $this->renderSourceCode($trace['file'],$trace['line'],$this->maxTraceSourceLines); ?>
<?php endforeach; ?>
