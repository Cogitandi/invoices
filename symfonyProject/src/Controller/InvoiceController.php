<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController {

    /**
     * @Route("/addInvoice", name="invoice")
     */
    public function index(Contractor $seller, Contractor $buyer, ArrayCollection $positions, 
                            $creationDate, $saleDate, $paymentDeadline, $paymentType, $priceList, $priceCurrency) {
        
        $invoice = new Invoice($creationDate, $saleDate, $paymentDeadline, $paymentType, $priceList, $seller, $buyer, $priceCurrency);
        
        foreach ($positions as $position) {
            $invoice->addPosition($position);
        }
        
        $invoice->setNewNumber();
        
        // save to db
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush($invoice);
    }

}
