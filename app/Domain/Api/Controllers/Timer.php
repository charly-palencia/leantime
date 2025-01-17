<?php

namespace Leantime\Domain\Api\Controllers {

    use Leantime\Core\Controller;
    use Leantime\Domain\Timesheets\Services\Timesheets as TimesheetService;
    class Timer extends Controller
    {
        private TimesheetService $timesheetService;

        /**
         * init - initialize private variables
         *
         * @access public
         * @params parameters or body of the request
         */
        public function init(TimesheetService $timesheetService)
        {
            $this->timesheetService = $timesheetService;
        }

        /**
         *
         *
         *
         * @access public
         * @params parameters or body of the request
         */
        public function get($params)
        {
        }


        /**
         *
         *
         *
         * @access public
         * @params parameters or body of the request
         */
        public function post($params)
        {

            if (isset($params["action"]) === true && $params["action"] == "start") {
                $ticketId = filter_var($params["ticketId"], FILTER_SANITIZE_NUMBER_INT);
                $this->timesheetService->punchIn($ticketId);
                echo "{status:ok}";
                return;
            }

            if (isset($params["action"]) === true && $params["action"] == "stop") {
                $ticketId = filter_var($params["ticketId"], FILTER_SANITIZE_NUMBER_INT);
                $hoursBooked = $this->timesheetService->punchOut($ticketId);

                if ($hoursBooked) {
                    echo $hoursBooked;
                    return;
                } else {
                    return "{status:failure}";
                }
                return;
            }

            echo "{status:failure}";
            return;
        }
    }

}
