import { FC, HTMLAttributes } from "react";
import { Carousel } from "react-responsive-carousel";
import { TrustCard } from "./TrustCard";
import 'react-responsive-carousel/lib/styles/carousel.min.css';
import { ReviewType } from "@/frontend/data/models";

interface TrustCarouselProps extends HTMLAttributes<HTMLDivElement> {
    reviews: ReviewType[];
}

export const TrustCarousel: FC<TrustCarouselProps> = ({
    className,
    reviews
}) => {
    return (
        <Carousel
            className={className}
            showArrows={false}
            stopOnHover={false}
            transitionTime={1000}
            interval={3000}
            infiniteLoop={true}
            autoPlay={true}
            showThumbs={false}
        >
            {reviews.map((review, id) => (
                <TrustCard
                    key={id}
                    className='w-full'
                    title={review.name}
                    description={review.content}
                    author={review.writer}
                    image={review.image}
                />
            ))}
        </Carousel>
    );
}