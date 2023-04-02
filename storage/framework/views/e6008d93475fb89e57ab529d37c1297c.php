<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" style=" width: auto!important; margin: 0!important;">
                    <div class="card-body">
                        <?php if(Auth::check()): ?>
                            <?php if(session('access_token')): ?>
                                <index-app access-token="<?php echo e(json_encode(session('access_token'))); ?>"
                                           tab="<?php echo e('first'); ?>"></index-app>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php echo e('Iniciar Session!!'); ?>

                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/markillat/Workspace/Proyecto-dev/resources/views/home.blade.php ENDPATH**/ ?>