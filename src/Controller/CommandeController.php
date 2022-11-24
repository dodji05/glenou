<?php

namespace App\Controller;


use App\Entity\AdresseLivraison;
use App\Entity\Commandes;
use App\Entity\LignesCommande;
use App\Form\AdresseLivraisonType;
use App\Form\CommandeType;
use App\Repository\CommandesRepository;

use App\Repository\LignesCommandeRepository;
use App\Repository\ProduitRepository;
use App\Services\Panier\PanierService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CommandeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande", name="commande")
     */

    public function index(PanierService $panier)
    {

        if (!$this->getUser()->getAdresseLivraison()->getValues()) {
            return $this->redirectToRoute('app_adresse_livraison_new');
        }

        $form = $this->createForm(CommandeType::class, null, [
            'user' => $this->getUser()
        ]);
        $total = 0;
        foreach ($panier->getFull() as $item) {
            $subtotal = (int)$item['produit']->getPrix() * $item['quantite'];
            $total += $subtotal;

        }
        return $this->render('commande/index.html.twig', [
            'form' => $form->createView(),
            'elements' => $panier->getFull(),
            'total' => $total
        ]);
    }

    /**
     * @Route("/commande/checkout", name="commande_checkout")
     */
    public function checkout(Request $request, PanierService $panier)
    {
        $form = $this->createForm(CommandeType::class, null, [
            'user' => $this->getUser()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commande = new Commandes();
            $methodepaiement = $form->get('paiement')->getData();
            $adreesse = $form->get('adresse')->getData();

            if($methodepaiement =='mobile'){
                return $this->redirectToRoute('commande_paiement_kkiapay');
            }

            $commande->setClient($this->getUser()->getId());
          //  $commande->setIsPaid(false);
            //$commande->setMethodePaiement($methodepaiement);
            $commande->setAdresselivraison($adreesse);

            //$commande->setEtatLivraison('non livre');

            $this->entityManager->persist($commande);

            $total = 0;
            foreach ($panier->getFull() as $product) {
                $ligne = new LignesCommande();
                $ligne->setCommande($commande);
                $ligne->setProduit($product['produit']);
                $ligne->setPrix($product['produit']->getPrix());
//                $ligne->setUniteMesure($product['produit']->getUniteMesure());
                $ligne->setQuantite($product['quantite']);

                $subtotal = (int)$product['produit']->getPrix() * $product['quantite'];
                $total += $subtotal;

                $this->entityManager->persist($ligne);

            }
//           $this->entityManager->flush();
            $total = 0;
            foreach ($panier->getFull() as $item) {
                $subtotal = (int)$item['produit']->getPrix() * $item['quantite'];
                $total += $subtotal;

            }


        }
        return $this->render('commande/checkOut.html.twig', [
            'form' => $form->createView(),
            'elements' => $panier->getFull(),
            'addresse' => $adreesse,
            'methodepaiement' => $methodepaiement,
            'commande'=>$commande,
            'total' => $total
        ]);

    }

    /**
     * @Route("/commande/termine/{id}", name="commande_end")
     */
    public function invoice(Commandes $commandes){
        return $this->render('commande/invoice.html.twig',[
            'commande'=>$commandes
        ]);
    }

    /**
     * @Route("/commande/panier", name="commmande_panier_affichage")
     */
    public function panierAffichage(SessionInterface $session, ProduitRepository $produitRepository, Request $request)
    {
        $panier = $session->get('panier', []);
        $panierdata = [];

        $rand_id = [];
        for ($i = 1; $i <= 5; $i++) {
            $rand_id[] = random_int(1, 160);
        }

        $produit_randon = $produitRepository->findBy(['id' => $rand_id]);

//        $livraison = new Quartier();
//        $form = $this->createForm(FraisLivraisonType::class, $livraison);
        //    $form->handleRequest($request);
        foreach ($panier as $id => $quantity) {
            $panierdata[] = [
                'produit' => $produitRepository->find($id),
                'quantite' => $quantity

            ];

        }
        //dd($panierdata);

        $total = 0;
        foreach ($panierdata as $item) {
            $subtotal = (int)$item['produit']->getPrix() * $item['quantite'];
            $total += $subtotal;

        }

        return $this->render('commande/panier.html.twig', [
            'elements' => $panierdata,
            'total' => $total,
            //'form' => $form->createView(),
            'produit_rand' => $produit_randon
        ]);
    }

    /**
     * @Route("/panier/{id}", name="ajout_panier")
     */
    public function ajout_panier($id, PanierService $panier)
    {
        $panier->ajout($id);
//        return $this->render('commmande/index.html.twig', [
//            'controller_name' => 'CommmandeController',
//        ]);
        return $this->redirectToRoute('commmande_panier_affichage');
    }

    /**
     * @Route("/validation/commande", name="commande_chechkout")
     */
    public function checkoutz(Request $request, SessionInterface $session, ProduitRepository $produitRepository, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer, CommandesRepository $commandesRepository)
    {
        // $panier->ajout($id);
        $form = $this->createForm(UserRegistrationFormType::class)
            ->add('Methodepayement', ChoiceType::class, [
                    'choices' => [
                        'Paiement à livraison' => "livraison",
                        'MoMo/Flooz/Carte Visa' => "paie",

                    ],
                    'mapped' => false,
                    'expanded' => true,
                    'multiple' => false,
                    'attr' => [
                        'class' => 'custom-control-label'
                    ]

                ]

            );

        $panier = $session->get('panier', []);


        $panierdata = [];
        foreach ($panier as $id => $quantity) {
            $panierdata[] = [
                'produit' => $produitRepository->find($id),
                'quantite' => $quantity

            ];

        }
        $total = 0;
        foreach ($panierdata as $item) {
            $subtotal = (int)$item['produit']->getPrix() * $item['quantite'];
            $total += $subtotal;

        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //  dd($form['Methodepayement']->getData());


            $entityManager = $this->getDoctrine()->getManager();


            $commande = new Commandes();


            // enregistrement des produits de la commande
            foreach ($panier as $id => $quantity) {
                $lignescommande = new LignesCommande();
                $lignescommande->setCommande($commande);
                $lignescommande->setProduit($produitRepository->find($id));
                $lignescommande->setPrix($produitRepository->find($id)->getPrix());
                $lignescommande->setQuantite($quantity);
                $entityManager->persist($lignescommande);

            }

            //fin

            $user = $form->getData();
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $form['plainPassword']->getData()

            ));
            $user->addRole("ROLE_CLIENT");
            $user->setEnabled(true);

            $entityManager->persist($user);
            $commande->setUser($user);
            $commande->setEtat('Encours');
            $commande->setClient(1);
            $entityManager->persist($commande);
            $entityManager->flush();

            $session->set('commande_id', $commande->getId());

            if ($form['Methodepayement']->getData() == true) {
                $session->set("montant", $total);
                $session->set("methodpaiement", "kkipay");
                return $this->redirectToRoute('commande_paiement_kkiapay');

            }


            $lacommande = $commandesRepository->find($commande->getId());
            /*   $email = (new TemplatedEmail())
                   ->from('jinukun@jinukun.com')
                   ->to(new Address('commande@jinukun.com'))
                   ->priority(Email::PRIORITY_HIGH)
                   ->subject('[Commande]Nouvelle commande ')

   //                // path of the Twig template to render
                   ->htmlTemplate('mails/signup.html.twig')

   //                // pass variables (name => value) to the template
                   ->context([

                       'commande' => $commande,
                   ]);
               $mailer->send($email);*/

            return $this->redirectToRoute('commande_paiement');

        }
        return $this->render('commmande/panier/checkout.html.twig', [
            'elements' => $panierdata,
            'total' => $total,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/paiement/kkiapay", name="commande_paiement_kkiapay")
     */

    public function kkiapay(SessionInterface $session)
    {

        return $this->render('commmande/kkiapay.html.twig', [
            'total' => $session->get("montant"),

        ]);

    }

    /**
     * @Route("/paiement/details-facture", name="commande_paiement")
     */
    public function facture(SessionInterface $session, LignesCommandeRepository $lignesCommandeRepository, CommandesRepository $commandesRepository, MailerInterface $mailer)
    {
        $idcommande = $session->get('commande_id', null);

        $methodpaiement = $session->get('methodpaiement', null);
        $produits = $lignesCommandeRepository->findBy(['commande' => $idcommande]);
        $lacommande = $commandesRepository->find($idcommande);


        //dd($panierdata);

        $total = 0;

        foreach ($produits as $item) {
            $subtotal = (int)$item->getPrix() * $item->getQuantite();
            $total += $subtotal;

        }
        $email = (new TemplatedEmail())
            ->from('jinukun@jinukun.com')
            ->to(new Address('commande@jinukun.com'))
            //->to(new Address('gildas31@gmail.com'))
            ->priority(Email::PRIORITY_HIGH);
        if ($methodpaiement == "kkipay") {
            $email->subject('[Commande déja payée en ligne]Nouvelle commande');
        } else {
            $email->subject('Nouvelle commande');
        }
        $email

            // path of the Twig template to render
            ->htmlTemplate('mails/signup.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'methodpaiement' => $methodpaiement,
                'commande' => $lacommande,
            ]);
        $mailer->send($email);


        return $this->render('commmande/panier/facture.html.twig', [
            'commande' => $produits,
            'total' => $total,
            'lacommande' => $lacommande

        ]);
    }

    /**
     * @Route("/panier/supprimer/{id}", name="supprimer_du_panier")
     */
    public function supprimer($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        if (!empty ($panier[$id])) {
            unset($panier[$id]);

        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('commmande_panier_affichage');


    }

    /**
     * @Route("/panier-ajax/{id}", name="ajout_panier_ajax")
     */
    public function ajout_panier_ajax($id, PanierService $panier, ProduitRepository $produitRepository, SessionInterface $session)
    {
        $panier->ajout($id);

//        return $this->render('commmande/index.html.twig', [
//            'controller_name' => 'CommmandeController',
//        ]);
        //   return $this->redirectToRoute('commmande_panier_affichage');
        $panier = $session->get('panier', []);
        $panierdata = [];
        foreach ($panier as $ids => $quantity) {
            $panierdata[] = [
                'produit' => $produitRepository->find($ids),
                'quantite' => $quantity

            ];

        }
        $total = 0;
        foreach ($panierdata as $item) {
            $subtotal = (int)$item['produit']->getPrix() * $item['quantite'];
            $total += $subtotal;

        }
        $produit = $produitRepository->find($id);

        $session->set('panierdata', $panierdata);


        return $this->json([
            'id' => $produit->getId(),
            'nom' => $produit->getNom(),
            'prix' => $produit->getPrix(),
            'image' => $produit->getImagePrincipale()
        ], 200);
    }

    /**
     * @Route("/reservation", name="reservation")
     */

    public function reservation(Request $request, SessionInterface $session)
    {
        $reservation = new Reservation();
        $items = new ReservationItems();


        $reservation->addItem($items);

        $form = $this->createForm(ReservationType::class, $reservation);
        // dd()
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            foreach ($form->getData()->getItems() as $item) {
                $item->setReservations($reservation);
                $entityManager->persist($item);

            }
            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('notice', 'Votre reservation enregistrée avec sucess ');
            $session->set('reservation_id', $reservation->getId());

            return $this->redirectToRoute('end_reservation');
        }
//

        return $this->render('commmande/reservations/nouvelle_reservation.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/reservation-success", name="end_reservation")
     */
    public function reservationFin(SessionInterface $session, ReservationRepository $reservationRepository, ReservationItemRepository $itemRepository)
    {
        $idresevation = $session->get('reservation_id', null);
        $produits = $itemRepository->findBy(['reservations' => $idresevation]);
        $lareservation = $reservationRepository->find($idresevation);


        //dd($panierdata);

        $total = 0;

        foreach ($produits as $item) {
            $subtotal = (int)$item->getPrix() * $item->getQuantite();
            $total += $subtotal;

        }
        return $this->render('commmande/reservations/facture-reservation.html.twig', [
            'commande' => $produits,
            'total' => $total,
            'lacommande' => $lareservation

        ]);

    }

    /**
     * @Route("recherche/produits/", name="frontend_recherche_produit")
     **/
    public function rechercheProduit(Request $request, PaginatorInterface $paginator)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $produits = $paginator->paginate(
            $entityManager->getRepository('App:Produit')->SearchProduit($request->query->get('searchProduit')), // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            15 // Nombre de résultats par page
        );

//            $produitRepository->SearchProduit($request->query->get('searchProduit'));
//        dd($produits);
        $topproduit = $entityManager->getRepository('App:Produit')->findBy(['id' => [3, 5, 6, 9, 4]]);
        return $this->render('front-end/produits/boutique.html.twig', [
            'produits' => $produits,
            'lacategorie' => 'Resultat de la recherche pour : ' . $request->query->get('searchProduit'),
            'topproduit' => $topproduit
        ]);
    }


}
