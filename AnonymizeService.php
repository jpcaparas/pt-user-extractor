<?php

class AnonymizeService {
    public function anonymizeEmail(User $user): User {
        $emailParts = explode('@', $user->getEmail());
        
        // Anonymize local part of the email
        $anonymizedLocalPart = substr($emailParts[0], 0, 3) . '...';

        // Split the domain part
        $domainParts = explode('.', $emailParts[1]);

        // Iterate through each domain part, anonymizing all but the last part (TLD)
        foreach ($domainParts as $index => &$part) {
            // If it's not the last part
            if ($index !== count($domainParts) - 1) {
                $part = substr($part, 0, 3) . '...';
            }
        }

        // Combine the domain parts back together
        $anonymizedDomain = implode('.', $domainParts);

        $anonymizedEmail = $anonymizedLocalPart . '@' . $anonymizedDomain;
        $user->setEmail($anonymizedEmail);
        return $user;
    }
}
