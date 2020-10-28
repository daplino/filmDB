<?php
namespace App\Serializer\Normalizer;

use App\Entity\Work;
use App\Entity\Crew;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * User normalizer
 */
class WorkNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'title'   => $object->getTitle(),
            /*'crew' => array_map(
                function (Crew $crew) {
                    return $crew->getId();
                },
                $object->getCrew()
            )*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Work;
    }
}
?>
