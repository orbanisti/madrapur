import csv
import os
from sumy.parsers.html import HtmlParser
from sumy.parsers.plaintext import PlaintextParser
from sumy.nlp.tokenizers import Tokenizer
from sumy.summarizers.lsa import LsaSummarizer as Lsa
from sumy.summarizers.luhn import LuhnSummarizer as Luhn
from sumy.summarizers.text_rank import TextRankSummarizer as TxtRank
from sumy.summarizers.lex_rank import LexRankSummarizer as LexRank
from sumy.summarizers.sum_basic import SumBasicSummarizer as SumBasic
from sumy.summarizers.kl import KLSummarizer as KL
from sumy.summarizers.edmundson import EdmundsonSummarizer as Edmundson
from sumy.nlp.stemmers import Stemmer
from sumy.utils import get_stop_words
import sys



text=sys.argv[1]



def __init__():
    LANGUAGE = "english"
    SENTENCES_COUNT = 1


    stemmer = Stemmer(LANGUAGE)

    lsaSummarizer = Lsa(stemmer)
    lsaSummarizer.stop_words = get_stop_words(LANGUAGE)
    luhnSummarizer = Luhn(stemmer)
    luhnSummarizer.stop_words = get_stop_words(LANGUAGE)
    # edmundsonSummarizer.bonus_words = get_bonus_words

    lexrankSummarizer = LexRank(stemmer)
    lexrankSummarizer.stop_words = get_stop_words(LANGUAGE)

    textrankSummarizer = TxtRank(stemmer)
    textrankSummarizer.stop_words = get_stop_words(LANGUAGE)

    sumbasicSummarizer = SumBasic(stemmer)
    sumbasicSummarizer.stop_words = get_stop_words(LANGUAGE)

    klSummarizer = KL(stemmer)
    klSummarizer.stop_words = get_stop_words(LANGUAGE)

    parser = HtmlParser.from_string(text, 0, Tokenizer(LANGUAGE))

    print('summarized')
    allvariations = []

    for sentence in lsaSummarizer(parser.document, SENTENCES_COUNT):
        print("Summarizing text via LSA: ")
        print(sentence)
        allvariations.append(sentence)
    for sentence in luhnSummarizer(parser.document, SENTENCES_COUNT):
        print("Summarizing text via Luhn: ")
        print(sentence)
        allvariations.append(sentence)
    for sentence in lexrankSummarizer(parser.document, SENTENCES_COUNT):
        print("Summarizing text via Lexrank: ")
        print(sentence)
        allvariations.append(sentence)
    for sentence in textrankSummarizer(parser.document, SENTENCES_COUNT):
        print("Summarizing text via Textrank: ")
        print(sentence)
        allvariations.append(sentence)
    for sentence in sumbasicSummarizer(parser.document, SENTENCES_COUNT):
        print("Summarizing text via Sumbasic: ")
        print(sentence)
        allvariations.append(sentence)
    for sentence in klSummarizer(parser.document, SENTENCES_COUNT):
        print("Summarizing text via klSum: ")
        print(sentence)
        allvariations.append(sentence)
        return allvariations

__init__()
