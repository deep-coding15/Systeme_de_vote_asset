
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }

       

        /* Hero Section */
        .hero {
            background: #f8f9fa;
            color: black;
            padding: 4rem 5%;
            text-align: center;
        }

        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero h3 {
            font-size: 1.2rem;
            font-weight: 400;
        }

        /* Candidats Section */
        .candidats {
            padding: 4rem 5%;
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            /* flex-direction: column; */
            gap: 3rem;
        }

        .candidat {
            background: white;
            border-radius: 20px;
            width: 40%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            flex: 0 0 40%;
            /* flex-grow | flex-shrink | flex-basis */
            /* ou une approche basée sur la largeur si votre design le permet */
            /*width: calc(50% - 1rem); /* Exemple pour deux éléments avec un gap de 1rem */
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .candidat:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(255, 107, 107, 0.15);
        }

        .candidat-header {
            background: linear-gradient(135deg, #FFE5E5, #FFF0F0);
            padding: 2.5rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            border-bottom: 3px solid #FF6B6B;
        }

        .candidat-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #FF6B6B;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .candidat-info h3 {
            color: #FF6B6B;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .candidat-info p {
            color: #666;
            font-size: 1.1rem;
            font-style: italic;
        }

        .candidat-body {
            padding: 2.5rem;
            display: grid;
            gap: 2rem;
        }

        .section-block {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid #FF6B6B;
        }

        .section-block h3 {
            color: #FF6B6B;
            font-size: 1.3rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-block h3::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #FF6B6B;
            border-radius: 50%;
        }

        .programme p {
            color: #555;
            line-height: 1.8;
            text-align: justify;
        }

        .experience ul {
            list-style: none;
            padding-left: 0;
        }

        .experience li {
            color: #555;
            padding: 0.5rem 0;
            padding-left: 1.5rem;
            position: relative;
        }

        .experience li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #FF6B6B;
            font-weight: bold;
        }

        .priorite ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            padding-left: 0;
        }

        .priorite li {
            background: #FF6B6B;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: transform 0.2s;
        }

        .priorite li:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(255, 107, 107, 0.3);
        }


        /* Responsive */
        @media (max-width: 768px) {
            .hero h2 {
                font-size: 1.8rem;
            }

            .hero h3 {
                font-size: 1rem;
            }

            .candidat-header {
                flex-direction: column;
                text-align: center;
            }

            .candidat-header img {
                width: 100px;
                height: 100px;
            }

            .priorite ul {
                justify-content: center;
            }
        }
    </style>

   
        <section class="hero">
            <h2>Les Candidats</h2>
            <h3>Découvrez les profils des candidats à la présidence de l'ASSET.</h3>
        </section>

        <section class="candidats">
            <!-- Candidat 1 -->

            <?php foreach ($candidats as $key => $candidat) : ?>
                <div class="candidat">
                    <div class="candidat-header">
<!--                         <img src="<?= $candidat['photo'] ?>" alt="Photo de <?= $candidat['nom'] ?> <?= $candidat['prenom'] ?>">
 -->                        <div class="candidat-info">
                            <h3> <?= $candidat['prenom'] ?> <?= $candidat['nom'] ?> </h3>
                            <p> <?= $candidat['description'] ?> </p>
                        </div>
                    </div>
                    <div class="candidat-body">
                        <div class="section-block programme">
                            <h3>Programme</h3>
                            <p> <?= $candidat['programme'] ?></p>
                        </div>
                        <?php $candidat['experiences'] = explode('||', $candidat['experiences']); ?>
                        <?php $candidat['priorites'] = explode('||', $candidat['priorites']); ?>
                        <div class="section-block experience">
                            <h3>Expérience</h3>
                            <ul>
                                <?php foreach ($candidat['experiences'] as $key => $experience) : ?>
                                    <li><?= $experience ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="section-block priorite">
                            <h3>Priorités</h3>
                            <ul>
                                <?php foreach ($candidat['priorites'] as $key => $priorite) : ?>
                                    <li><?= $priorite ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    