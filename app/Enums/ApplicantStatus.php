<?php

namespace App\Enums;

enum ApplicantStatus: string
{
    case Accept = 'accept';
    case Pending = 'pending';
    case PriorityPending = 'priority_pending';
    case NotAccepted = 'not_accepted';
    case AcceptMechanism = 'accept_mechanism';
    case NotApplicable = 'not_applicable';
    case InterviewScheduled = 'interview_scheduled';
    case Completed = 'completed';

}
