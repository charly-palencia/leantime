<?php

namespace Leantime\Domain\Ideas\Controllers {

    use Leantime\Core\Controller;
    use Leantime\Domain\Auth\Models\Roles;
    use Leantime\Domain\Ideas\Repositories\Ideas as IdeaRepository;
    use Leantime\Domain\Auth\Services\Auth;

    class DelCanvas extends Controller
    {
        private IdeaRepository $ideaRepo;

        /**
         * init - initialize private variables
         *
         * @access public
         */
        public function init(IdeaRepository $ideaRepo)
        {
            $this->ideaRepo = $ideaRepo;
        }

        /**
         * run - display template and edit data
         *
         * @access public
         */
        public function run()
        {

            Auth::authOrRedirect([Roles::$owner, Roles::$admin, Roles::$manager, Roles::$editor]);

            if (isset($_GET['id'])) {
                $id = (int)($_GET['id']);
            }

            if (isset($_POST['del']) && isset($id)) {
                $this->ideaRepo->deleteCanvas($id);

                unset($_SESSION['currentIdeaCanvas']);
                $this->tpl->setNotification($this->language->__("notification.idea_board_deleted"), "success");
                $this->tpl->redirect(BASE_URL . "/ideas/showBoards");
            }

            $this->tpl->display('ideas.delCanvas');
        }
    }
}
