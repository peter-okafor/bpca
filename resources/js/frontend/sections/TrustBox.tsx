import { FC } from "react"
import { TrustCard, TrustCarousel } from "../components"
import { ReviewType } from "../data/models"

interface TrustBoxProps {
    reviews: ReviewType[];
}

export const TrustBox: FC<TrustBoxProps> = ({
    reviews
}) => {
    return (
        <>
            <section className="min-h-fit overflow-hidden px-0 rounded-lg lg:px-[14.5%] lg:pb-[3%] lg:rounded-none">
                <div className="hidden lg:block h-full">
                    <h3 className="font-semibold text-pest-cyprus text-3xl text-center py-16">
                        Trusted By
                    </h3>
                    <div className="grid w-full lg:grid-cols-3 lg:gap-8">
                        {reviews.map((review, id) => (
                            // <TrustCard
                            //     key={id}
                            //     className='w-full'
                            //     title={review.name}
                            //     description={review.content}
                            //     author={review.writer}
                            //     image={review.image}
                            // />
                            <div key={id} className="bg-pest-aliceblue">
                                <div
                                    style={{
                                        backgroundImage: `url(${process.env.MIX_APP_AWS_S3}${review.image})`,
                                    }}
                                    className="h-40 bg-cover bg-center bg-slate-200 bg-opacity-80"
                                ></div>
                                <div className="space-y-6 p-10">
                                    <div className="font-bold">
                                        {review.name}
                                    </div>
                                    <div>{review.content}</div>
                                    <div className="text-gray-400">
                                        {review.writer}
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
                <TrustCarousel
                    reviews={reviews}
                    className="block lg:hidden h-full"
                />
            </section>
        </>
    );
}