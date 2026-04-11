from textblob import TextBlob
import pandas as pd

df = pd.read_csv("data_lake/feedback_raw.csv")

def get_sentiment(text):
    if pd.isna(text):
        return "Neutral"

    polarity = TextBlob(str(text)).sentiment.polarity

    if polarity > 0.2:
        return "Positive"
    elif polarity < -0.2:
        return "Negative"
    else:
        return "Neutral"


# Apply on all 3 columns
df["faculty_sentiment"] = df["faculty_feedback"].apply(get_sentiment)
df["curriculum_sentiment"] = df["curriculum_feedback"].apply(get_sentiment)
df["placement_sentiment"] = df["placement_feedback"].apply(get_sentiment)

# overall sentiment (important for dashboard)
df["overall_sentiment"] = df["overall_text_feedback"].apply(get_sentiment)

df.to_csv("data_lake/feedback_processed.csv", index=False)

print("Sentiment analysis completed")